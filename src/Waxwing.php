<?php

namespace Waxwing;

use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;
use Waxwing\Interfaces\ApplicationRoutingCallbackInterface;
use Waxwing\Interfaces\ApplicationRoutingInterface;
use Waxwing\Routes\RouteAnalyzer;

class Waxwing implements ApplicationRoutingInterface
{
    /** @var RouteCollector */
    private $routeCollector;
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setRouting(ApplicationRoutingCallbackInterface $callback, ?string $cacheFile = null): void
    {
        $routeParser = new \FastRoute\RouteParser\Std();
        $dataGenerator = new GroupCountBased();

        $routeCollector = new RouteCollector($routeParser, $dataGenerator);
        $callback($routeCollector);

        $this->routeCollector = $routeCollector;
    }

    public function generate(): void
    {
        $routeAnalyzer = new RouteAnalyzer($this->routeCollector, $this->container);
        $routeAnalyzer->analyze();
    }
}
