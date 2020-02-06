<?php

namespace Waxwing\Routing\DataGenerator;

use FastRoute\DataGenerator\RegexBasedAbstract as FRRegexBasedAbstract;

final class RegexBasedAbstract extends FRRegexBasedAbstract
{
    protected $routes;

    public function addRoute($httpMethod, $route, $handler, $parameterOptions)
    {
        $route = $this->currentGroupPrefix . $route;
        $routeDatas = $this->routeParser->parse($route);
        foreach ((array) $httpMethod as $method) {
            foreach ($routeDatas as $routeData) {
                $this->dataGenerator->addRoute($method, $routeData, $handler);
            }
        }
    }
}
