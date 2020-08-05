<?php


namespace RusLan\SeamlessMessage\Bundle\Routing;

use RusLan\SeamlessMessage\Bundle\Controller\SeamlessMessageController;
use RusLan\SeamlessMessage\Bundle\Doctrine\Type\ChatTypeEnum;
use RusLan\SeamlessMessage\Bundle\Doctrine\Type\SourceTypeEnum;
use RusLan\SeamlessMessage\Bundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class SeamlessMessageLoader extends Loader implements SeamlessMessageLoaderInterface
{
    private $loaded = false;
    private $loaderName = Configuration::name_bundle;

    /** @var array */
    private $bots;

    public function __construct(?array $bots = [])
    {
        $this->bots = $bots ?? [];
    }

    /**
     * @param mixed $resource
     * @param string|null $type
     * @return RouteCollection
     */
    public function load($resource, string $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException(sprintf('Do not add the "%s" loader twice', $type));
        }

        $routes = new RouteCollection();

        foreach ($this->bots as $botToken => $conf) {
            if (!isset($conf['source']) || !is_string($conf['source']) || !in_array($conf['source'], SourceTypeEnum::getChoices())) {
                throw new \RuntimeException('The configuration is incorrect. You need the bot\'s source.');
            }

            $this->reloadRoutes($routes, $botToken, $conf);
        }

        $this->loaded = true;

        return $routes;
    }

    /**
     * @param RouteCollection $routes
     * @param string $botToken
     * @param array $conf
     */
    private function reloadRoutes(RouteCollection &$routes, string $botToken, array $conf)
    {
        $botSource = $conf['source'];
        $botName = (string) ($conf['name'] ?? $botToken);

        $defaultAction = ($conf['default_controller'] ?? self::DEFAULT_ROUTER_CONTROLLER) . '::' . self::DEFAULT_ROUTER_ACTION;
        $defaultAction = (mb_substr($defaultAction, 0, 1) === '\\') ? mb_substr($defaultAction, 1) : $defaultAction;

        $routes->add(
            sprintf("%s_%s_%s", $botSource, $botName, self::DEFAULT_ROUTER_NAME),
            $this->newRoute(
                [
                    'action' => $defaultAction,
                    'method' => $conf['default_method'] ?? self::DEFAULT_ROUTER_METHOD,
                ],
                $botSource,
                $botToken,
                $botName
            )
        );

        foreach ($conf['routers'] ?? [] as $type => $routers) {
            if (!is_string($type) || !in_array($type, ChatTypeEnum::getChoices())) {
                continue;
            }
            foreach ($routers as $slugAction => $action) {
                if (!is_string($slugAction)) {
                    continue;
                }
                $routes->add(
                    sprintf("%s_%s_%s_%s", $botSource, $botName, $type, $slugAction),
                    $this->newRoute(
                        $action,
                        $botSource,
                        $botToken,
                        $botName,
                        $slugAction,
                        $type
                    )
                );
            }
        }
    }

    /**
     * @param array $action
     * @param string $botSource
     * @param string $botToken
     * @param string $botName
     * @param string|null $slugAction
     * @param string|null $type
     * @return Route
     */
    protected function newRoute(array $action, string $botSource, string $botToken, string $botName, string $slugAction = null, string $type = null): Route
    {
        return new Route(
            sprintf(
                "/%s/%s%s%s",
                $botSource,
                $botToken,
                ($type ? sprintf("/%s", $type) : null),
                ($slugAction ? sprintf("/%s", $slugAction) : null)
            ),
            [
                self::FIELD_CONTROLLER => $action['action'] ?? self::DEFAULT_ROUTER_CONTROLLER . '::' . self::DEFAULT_ROUTER_ACTION,
                self::FIELD_BOT_SOURCE => $botSource,
                self::FIELD_BOT_NAME => $botName,
                self::FIELD_ROUTE_SLUG => $slugAction ?? self::DEFAULT_ROUTER_NAME,
                self::FIELD_ROUTE_TYPE => $type,
            ],
            [],
            [],
            null,
            [],
            $action['method'] ?? self::DEFAULT_ROUTER_METHOD
        );
    }

    public function supports($resource, string $type = null)
    {
        return $this->loaderName === $type;
    }
}
