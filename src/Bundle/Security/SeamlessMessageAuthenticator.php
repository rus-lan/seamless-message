<?php

namespace RusLan\SeamlessMessage\Bundle\Security;

use RusLan\SeamlessMessage\Bundle\Doctrine\EntityManagerAwareInterface;
use RusLan\SeamlessMessage\Bundle\Doctrine\EntityManagerAwareTrait;
use RusLan\SeamlessMessage\Bundle\Doctrine\Repository\RepositoryAwareInterface;
use RusLan\SeamlessMessage\Bundle\Doctrine\Repository\RepositoryAwareTrait;
use RusLan\SeamlessMessage\Bundle\Doctrine\Type\SourceTypeEnum;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\ContentInterface;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram\Content as ContentTelegram;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex\Content as ContentYandex;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Slack\Content as ContentSlack;
use RusLan\SeamlessMessage\Bundle\Model\Messages\Entity\Log;
use RusLan\SeamlessMessage\Bundle\Model\Route\DTO\Action;
use RusLan\SeamlessMessage\Bundle\Model\User\Entity\User;
use RusLan\SeamlessMessage\Bundle\Routing\SeamlessMessageLoader;
use RusLan\SeamlessMessage\Bundle\Translation\TranslatorAwareInterface;
use RusLan\SeamlessMessage\Bundle\Translation\TranslatorAwareTrait;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class SeamlessMessageAuthenticator extends AbstractGuardAuthenticator implements RepositoryAwareInterface, EntityManagerAwareInterface, TranslatorAwareInterface
{
    use TranslatorAwareTrait;
    use EntityManagerAwareTrait;
    use RepositoryAwareTrait;

    /** @var Router */
    private $router;

    /** @var RequestStack */
    private $request;

    /** @var Action|null */
    private $action;

    /** @var bool */
    private $log;

    public function __construct(
        Router $router,
        bool $log = false
    ) {
        $this->router = $router;
        $this->log = $log;
    }

    public function supports(Request $request)
    {
        if ($this->log) {
            ($log = new Log())
                ->setIp($request->server->get('REMOTE_ADDR') ?? null)
                ->setMethod($request->server->get('REQUEST_METHOD') ?? null)
                ->setUrl($request->server->get('REQUEST_URI') ?? '')
                ->setUserAgent($request->server->get('HTTP_USER_AGENT') ?? 'robot')
                ->setContent((string) $request->getContent())
            ;
            $this->getEntityManager()->persist($log);
            $this->getEntityManager()->flush();
        }

        return ($this->router->match($request->getPathInfo())[SeamlessMessageLoader::FIELD_ROUTE] ?? null) !== 'homepage';
    }

    public function getCredentials(Request $request)
    {
        $this->action = new Action($this->router->match($request->getPathInfo()));

        $request->request->add([
            SeamlessMessageLoader::FIELD_ROUTE => &$this->action,
        ]);

        $class = SourceTypeEnum::getDTO($this->action->getBotSource());


        if (
            $class && (0 === strpos($request->headers->get('Content-Type'), 'application/json'))
        ) {
            $request->request->add([
                $this->action->getBotSource() => is_object(($data = json_decode((string) $request->getContent()))) ? new $class($data) : null,
            ]);
        } elseif (
            $class && (0 === strpos($request->headers->get('Content-Type'), 'application/x-www-form-urlencoded'))
            && mb_parse_str((string) $request->getContent(), $data)
        ) {
            if (isset($data['payload'])) {
                $data['payload'] = json_decode($data['payload']);
            }

            $request->request->add([
                $this->action->getBotSource() => is_array($data) ? new $class((object) $data) : null,
            ]);
        }

        return $request->request->get($this->action->getBotSource()) ?? false;
    }

    private function getUserToSlack(ContentSlack $content): User
    {
        $user = $this->getRepository()->findByAccount($content->getUserId(), $this->action->getBotName());

        return ($user instanceof User) ? $user : (new User())
            ->setAccountUid($content->getUserId())
            ->setUsername($content->getUserName())
            ->setType($this->action->getBotSource())
            ->setBotName($this->action->getBotName())
        ;
    }

    private function getUserToYandex(ContentYandex $content): User
    {
        $user = $this->getRepository()->findByAccount($content->getSession()->getApplication()->getApplicationId(), $this->action->getBotName());

        return ($user instanceof User) ? $user : (new User())
            ->setAccountUid($content->getSession()->getApplication()->getApplicationId())
            ->setLanguage($content->getMeta()->getLocale())
            ->setType($this->action->getBotSource())
            ->setBotName($this->action->getBotName())
        ;
    }

    private function matchRoute(?string $slug, ?string $type): bool
    {
        $search = sprintf("%s_", $this->action->getBotSource());

        /** @var Route $route */
        foreach ($this->router->getRouteCollection()->all() as $name => $route) {
            if (
                (stripos($name, $search) === 0)
                && ($route->getDefault(SeamlessMessageLoader::FIELD_ROUTE_SLUG) === $slug)
                && ($route->getDefault(SeamlessMessageLoader::FIELD_ROUTE_TYPE) === $type)
                && ($route->getDefault(SeamlessMessageLoader::FIELD_BOT_NAME) === $this->action->getBotName())
            ) {
                $this->action
                    ->setRouteName($name)
                    ->setController($route->getDefault(SeamlessMessageLoader::FIELD_CONTROLLER))
                    ->setRouteSlug($route->getDefault(SeamlessMessageLoader::FIELD_ROUTE_SLUG))
                    ->setRouteType($route->getDefault(SeamlessMessageLoader::FIELD_ROUTE_TYPE))
                ;

                $update = true;
                break;
            }
        }

        return $update ?? false;
    }

    private function filterRoutes(?string $lang, string $domain, string $allowed): array
    {
        return array_filter(
            $this->getTranslator()->getCatalogue($lang)->all($domain),
            function ($key) use ($allowed) {
                return (preg_match("/^$allowed/", $key));
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    private function getRoutes(?string $message, User $user, string $type, array $router = []): array
    {
        $message = trim($message ?? '');
        $history = $user->getHistory();

        if (
            mb_substr($message, 0, 1) === '/'
            &&  ($messages = explode(' ', $message))
            &&  count($messages)
            &&  $this->matchRoute(mb_substr($messages[0], 1), $type)
        ) {
            $router[] = $messages[0];
            $router[] = trim(str_replace($messages[0], '', $message));
        } elseif (
            ($domain = sprintf('%s_%s', SourceTypeEnum::source__telegram, $this->action->getBotName()))
            && ($allowed = sprintf('route.%s.', $type))
            && ($filtered = $this->filterRoutes($user->getLanguage(), $domain, $allowed))
            && count($filtered)
            && ($route = str_replace($allowed, '', array_search($message, $filtered)))
            && $this->matchRoute($route, $type)
        ) {
            $router[] = sprintf('/%s', $route);
        } elseif (
            ($allowed = sprintf('button.%s.', $type))
            && ($filtered = $this->filterRoutes($user->getLanguage(), $domain, $allowed))
            && count($filtered)
            && ($button = str_replace($allowed, '', array_search($message, $filtered)))
            && !empty($button)
            && $this->matchRoute(mb_substr($history[0] ?? '/', 1), $type)
        ) {
            $router += $history;
            $router[] = $button;
        } elseif (
            $this->matchRoute(mb_substr($history[0] ?? '/', 1), $type)
        ) {
            $router += $history;
            $router[] = $message;
        }

        return array_diff($router ?? [], ['']);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (!($credentials instanceof ContentInterface)) {
            // empty
        } elseif (
            ($credentials instanceof ContentTelegram)
            && $credentials->isMessage()
            && $credentials->getMessage()->isFrom()
        ) {
            $user = $userProvider->getUserToTelegram($credentials->getMessage()->getFrom(), $this->action->getBotName());

            $user->setHistory($this->getRoutes($credentials->getMessage()->getText(), $user, $credentials->getType()));
        } elseif (
            ($credentials instanceof ContentYandex)
            && $credentials->isMeta()
            && $credentials->isSession()
            && $credentials->getSession()->isApplication()
            && $credentials->isRequest()
        ) {
            $user = $this->getUserToYandex($credentials);

            $user->setHistory($this->getRoutes($credentials->getRequest()->getOriginalUtterance(), $user, $credentials->getType()));
        } elseif (
            ($credentials instanceof ContentSlack)
            && $credentials->isValid()
        ) {
            $user = $this->getUserToSlack($credentials);

            $user->setHistory($this->getRoutes($credentials->getCommand(), $user, $credentials->getType()));
        }

        if (($user ?? null) instanceof User) {
            $userProvider->persist($user)->flush();
        }

        return $user ?? null;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return ($user instanceof User) && $user->isValid();
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse([
            'message' => 'Authentication Required'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
