<?php

namespace RusLan\SeamlessMessage\Bundle\Controller;

use RusLan\SeamlessMessage\Bundle\Doctrine\Type\SourceTypeEnum;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\ContentInterface;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram\Content as ContentTelegram;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex\Content as ContentYandex;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Slack\Content as ContentSlack;
use RusLan\SeamlessMessage\Bundle\Model\Route\DTO\Action;
use RusLan\SeamlessMessage\Bundle\Model\User\Entity\User;
use RusLan\SeamlessMessage\Bundle\Routing\SeamlessMessageLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeamlessMessageController extends AbstractController
{
    /**
     * @param Request $request
     * @param string $source
     * @param string $class
     * @return ContentInterface|null
     */
    protected function getContentToRequest(Request $request, string $source, string $class): ?ContentInterface
    {
        return ($dataTelegram = $request->request->get($source))
            && ($dataTelegram instanceof $class)
            && ($dataTelegram instanceof ContentInterface)
            ? $dataTelegram : null;
    }

    /**
     * @param Request $request
     * @param string $route
     * @return Response
     */
    final public function defaultAction(Request $request, string $route = SeamlessMessageLoader::DEFAULT_ROUTER_NAME): Response
    {
        $dataTelegram = $this->getContentToRequest($request, SourceTypeEnum::source__telegram, ContentTelegram::class);
        $dataYandex = $this->getContentToRequest($request, SourceTypeEnum::source__yandex, ContentYandex::class);
        $dataSlack = $this->getContentToRequest($request, SourceTypeEnum::source__slack, ContentSlack::class);

        if (
            !($user = $this->getUser())
            || !($user instanceof User)
            || !($_route = $request->request->get(SeamlessMessageLoader::FIELD_ROUTE))
            || !($_route instanceof Action)
        ) {
            $response = $this->responseNotFound();
        } elseif ($_route->getController() !== static::class . '::' . SeamlessMessageLoader::DEFAULT_ROUTER_ACTION) {
            $response = $this->forwardAction(
                $_route->getController(),
                $request,
                $_route->getRouteSlug(),
                $dataSlack ?? $dataYandex ?? $dataTelegram ?? null
            );
        } elseif ($dataTelegram instanceof ContentTelegram) {
            $response = $this->resetHistory($_route->getRouteSlug())->defaultActionTelegram($request, $user, $dataTelegram);
        } elseif ($dataYandex instanceof ContentYandex) {
            $response = $this->resetHistory($_route->getRouteSlug())->defaultActionYandex($request, $user, $dataYandex);
        } elseif ($dataSlack instanceof ContentSlack) {
            $response = $this->resetHistory($_route->getRouteSlug())->defaultActionSlack($request, $user, $dataSlack);
        }

        return $response ?? $this->responseNotFound();
    }

    /**
     * @param string $controller
     * @param Request $request
     * @param ContentInterface|null $data
     * @param string $route
     * @return Response
     */
    protected function forwardAction(string $controller, Request $request, string $route, ?ContentInterface $data): Response
    {
        return $this->forward(
            $controller,
            [
                'request' => $request,
                'route' => $route,
                'data' => $data,
            ]
        );
    }

    /**
     * @param Request $request
     * @param User $user
     * @param ContentTelegram $data
     * @return Response
     */
    protected function defaultActionTelegram(Request $request, User $user, ContentTelegram $data): Response
    {
        return $this->getUser()->isBot()
            ? $this->responseOk()
            : $this->json([
                'method' => 'sendMessage',
                'chat_id' => $user->getAccountUid() ?? null,
                'text' => $this->renderView('@SeamlessMessageBundle/telegram.html.twig'),
            ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param ContentSlack $data
     * @return Response
     */
    protected function defaultActionSlack(Request $request, User $user, ContentSlack $data): Response
    {
        return $this->getUser()->isBot()
            ? $this->responseOk()
            : $this->json([
                'channel' => $data->getChannelId() ?? null,
                'blocks' => [
                    [
                        'type' => 'section',
                        'text' => $this->renderView('@SeamlessMessageBundle/slack.html.twig'),
                    ],
                ],
            ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param ContentYandex $data
     * @return Response
     */
    protected function defaultActionYandex(Request $request, User $user, ContentYandex $data): Response
    {
        return $this->json([
            'version' => $data->getVersion(),
            'session' => $data->getSession()->getSource(),
            'response' => [
                'text' => $this->renderView('@SeamlessMessageBundle/yandex.html.twig'),
                'end_session' => false,
            ],
        ], Response::HTTP_OK);
    }
}
