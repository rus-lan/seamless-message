<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Route\DTO;

use RusLan\SeamlessMessage\Bundle\Routing\SeamlessMessageLoader;

class Action
{
    /** @var string|null */
    private $controller;

    /** @var string|null */
    private $routeType;
    /** @var string|null */
    private $routeName;
    /** @var string|null */
    private $routeSlug;

    /** @var string|null */
    private $botSource;
    /** @var string|null */
    private $botName;

    public function __construct(array $router = [])
    {
        $this->controller = $router[SeamlessMessageLoader::FIELD_CONTROLLER] ?? $this->controller;

        $this->routeName = $router[SeamlessMessageLoader::FIELD_ROUTE] ?? $this->routeName;
        $this->routeSlug = $router[SeamlessMessageLoader::FIELD_ROUTE_SLUG] ?? $this->routeSlug;
        $this->routeType = $router[SeamlessMessageLoader::FIELD_ROUTE_TYPE] ?? $this->routeType;

        $this->botName = $router[SeamlessMessageLoader::FIELD_BOT_NAME] ?? $this->botName;
        $this->botSource = $router[SeamlessMessageLoader::FIELD_BOT_SOURCE] ?? $this->botSource;
    }

    /**
     * @return string|null
     */
    public function getController(): ?string
    {
        return $this->controller;
    }

    /**
     * @param string|null $controller
     * @return static
     */
    public function setController(?string $controller): self
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRouteType(): ?string
    {
        return $this->routeType;
    }

    /**
     * @param string|null $routeType
     * @return static
     */
    public function setRouteType(?string $routeType): self
    {
        $this->routeType = $routeType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    /**
     * @param string|null $routeName
     * @return static
     */
    public function setRouteName(?string $routeName): self
    {
        $this->routeName = $routeName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRouteSlug(): ?string
    {
        return $this->routeSlug;
    }

    /**
     * @param string|null $routeSlug
     * @return static
     */
    public function setRouteSlug(?string $routeSlug): self
    {
        $this->routeSlug = $routeSlug;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBotSource(): ?string
    {
        return $this->botSource;
    }

    /**
     * @param string|null $botSource
     * @return static
     */
    public function setBotSource(?string $botSource): self
    {
        $this->botSource = $botSource;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBotName(): ?string
    {
        return $this->botName;
    }

    /**
     * @param string|null $botName
     * @return static
     */
    public function setBotName(?string $botName): self
    {
        $this->botName = $botName;
        return $this;
    }
}
