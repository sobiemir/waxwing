<?php

namespace Waxwing\Routes;

use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use Waxwing\Interfaces\ActionInterface;

final class RouteAnalyzer
{
    /** @var RouteCollector */
    private $routeCollector;
    /** @var ContainerInterface */
    private $container;
    /** @var array */
    private $groupedRoutes;
    /** @var array */
    private $routes;

    public function __construct(RouteCollector $routeCollector, ContainerInterface $container)
    {
        $this->routeCollector = $routeCollector;
        $this->container = $container;
    }

    public function analyze()
    {
        $routeData = $this->routeCollector->getData();
        $staticRoutes = $routeData[0];
        $dynamicRoutes = $routeData[1];

        foreach ($staticRoutes as $method => $routes)
        {
            foreach ($routes as $route => $handler)
            {
                $actionInstance = new $handler($this->container);

                if ($actionInstance instanceof ActionInterface) {
                    $descriptor = $actionInstance->getActionDescriptor();

                    $reflectionClass = new ReflectionClass($handler);
                    print_r($reflectionClass->getDocComment());
                    print_r($reflectionClass);

                    continue;
                }
                die('Action must be an instance of the ActionInterface object.');
            }
        }
    }
}
