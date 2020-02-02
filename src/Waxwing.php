<?php

namespace Waxwing;

use FastRoute\DataGenerator\GroupCountBased;
use Waxwing\Interfaces\ApplicationRoutingInterface;
use Waxwing\Routes\RouteCollector;

class Waxwing implements ApplicationRoutingInterface
{
    private $routeCollector;

    public function setRouting(callable $callback, string $cacheFile = null): void
    {
        $routeParser = new \FastRoute\RouteParser\Std();
        $dataGenerator = new GroupCountBased();

        $routeCollector = new RouteCollector($routeParser, $dataGenerator);
        $callback($routeCollector);

        $this->routeCollector = $routeCollector;
    }

    public function generate(): void
    {
    }
}
