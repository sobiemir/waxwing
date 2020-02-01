<?php
namespace Waxwing\Routes;

use FastRoute\RouteCollector as FRRouteCollector;

final class RouteCollector extends FRRouteCollector
{
    protected $routes;

    public function addRoute($httpMethod, $route, $handler)
    {
        $route = $this->currentGroupPrefix . $route;
        $routeDatas = $this->routeParser->parse($route);
    }
}
