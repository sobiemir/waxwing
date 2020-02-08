<?php

namespace Waxwing\Interfaces;

use FastRoute\RouteCollector;

interface ApplicationRoutingCallbackInterface
{
    public function __invoke(RouteCollector $routeCollector): void;
}
