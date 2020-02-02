<?php

namespace Waxwing\Interfaces;

use FastRoute\RouteCollector;

interface ApplicationRoutingCallbackInterface
{
    function __invoke(RouteCollector $routeCollector): void;
}
