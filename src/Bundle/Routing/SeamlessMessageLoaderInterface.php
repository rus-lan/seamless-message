<?php

namespace RusLan\SeamlessMessage\Bundle\Routing;

use RusLan\SeamlessMessage\Bundle\Controller\SeamlessMessageController;

interface SeamlessMessageLoaderInterface
{
    public const FIELD_CONTROLLER = '_controller';

    public const FIELD_ROUTE = '_route';
    public const FIELD_ROUTE_TYPE = '_route_type';
    public const FIELD_ROUTE_SLUG = '_route_slug';

    public const FIELD_BOT_SOURCE = '_bot_source';
    public const FIELD_BOT_NAME = '_bot_name';

    public const DEFAULT_ROUTER_NAME = 'default';
    public const DEFAULT_ROUTER_CONTROLLER = SeamlessMessageController::class;
    public const DEFAULT_ROUTER_ACTION = 'defaultAction';
    public const DEFAULT_ROUTER_METHOD = 'post';
}
