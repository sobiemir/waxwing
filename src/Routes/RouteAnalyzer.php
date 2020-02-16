<?php

namespace Waxwing\Routes;

use FastRoute\RouteCollector;
use Laminas\Code\Reflection\ClassReflection;
use LogicException;
use phpDocumentor\Reflection\DocBlockFactory;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use RuntimeException;
use Waxwing\Interfaces\ActionInterface;
use Waxwing\Tags\CategoryTag;

final class RouteAnalyzer
{
    /** @var RouteCollector */
    private $routeCollector;
    /** @var ContainerInterface */
    private $container;
    /** @var array */
    private $routeCategories;
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
            foreach ($routes as $route => $handler)
                $this->analyzeStaticRoute($handler, $route, $method);

        foreach ($dynamicRoutes as $method => $routes)
            foreach ($routes as $routeInfo)
                $this->analyzeDynamicRoute($routeInfo, $method);

        print_r($this->routeCategories);
        // print_r($this->routes);
    }

    private function getActionInstance(string $handler): ActionInterface
    {
        if ($handler == null) {
            throw new RuntimeException('Route handler cannot be null.');
        }
        $actionInstance = new $handler($this->container);
        if ($actionInstance instanceof ActionInterface) {
            return $actionInstance;
        }
        throw new RuntimeException('Action must be an instance of the ActionInterface object.');
    }

    private function analyzeStaticRoute(string $handler, string $route, string $method): void
    {
        $actionInstance = $this->getActionInstance($handler);
        $actionDescriptor = $actionInstance->getActionDescriptor();
        $routeDescriptor = new RouteDescriptor();

        $routeDescriptor->action = $handler;
        $routeDescriptor->method = $method;
        $routeDescriptor->route = $route;
        $routeDescriptor->routeVariables = [];
        $routeDescriptor->isBodyRequired = $actionDescriptor->isBodyRequired();
        $routeDescriptor->bodyClass = $actionDescriptor->getBodyClass();
        $routeDescriptor->responseClass = $actionDescriptor->getResponseClass();
        $routeDescriptor->responseCode = $actionDescriptor->getResponseCode();

        $this->addToRouteDescriptor($handler, $routeDescriptor);
    }

    private function analyzeDynamicRoute(array $routeInfo, string $method): void
    {
        $routeMap = $routeInfo['routeMap'];
        $handler = null;

        $route = '';
        $routeVariables = [];

        foreach ($routeMap as $variableMap) {
            if ($handler != null && $handler !== $variableMap[0]) {
                throw new RuntimeException('The same route with different handlers is not supported.');
            }
            $handler = $variableMap[0];
        }
        if (!isset($variableMap[2])) {
            throw new LogicException('One of the routes is corrupted.');
        }
        foreach ($variableMap[2] as $path) {
            if (is_array($path)) {
                $route .= '{' . $path[0] . '}';
                $type = 'string';
                if ($path[1] === '\\d+' || $path[1] === '[0-9]+') {
                    $type = 'number';
                }
                $routeVariables[$path[0]] = $type;
            } else {
                $route .= $path;
            }
        }

        $actionInstance = $this->getActionInstance($handler);
        $actionDescriptor = $actionInstance->getActionDescriptor();
        $routeDescriptor = new RouteDescriptor();

        $routeDescriptor->action = $handler;
        $routeDescriptor->method = $method;
        $routeDescriptor->route = $route;
        $routeDescriptor->routeVariables = $routeVariables;
        $routeDescriptor->isBodyRequired = $actionDescriptor->isBodyRequired();
        $routeDescriptor->bodyClass = $actionDescriptor->getBodyClass();
        $routeDescriptor->responseClass = $actionDescriptor->getResponseClass();
        $routeDescriptor->responseCode = $actionDescriptor->getResponseCode();

        $this->addToRouteDescriptor($handler, $routeDescriptor);
    }

    private function addToRouteDescriptor(string $handler, RouteDescriptor $routeDescriptor): void
    {
        $reflectionClass = new ReflectionClass($handler);
        $factory = DocBlockFactory::createInstance([
            'category' => CategoryTag::class
        ]);
        $docBlock = $factory->create($reflectionClass->getDocComment());

        $categoryTags = $docBlock->getTagsByName('category');
        $categoryTag = current($categoryTags) ?? null;

        if ($categoryTag instanceof CategoryTag) {
            $category = $categoryTag->getCategoryName();
            if (!isset($this->routeCategories[$category])) {
                $this->routeCategories[$category] = [];
            }
            $routeDescriptor->category = $category;
            $this->routeCategories[$category][] = $routeDescriptor;
        } else {
            $routeDescriptor->category = '';
            $this->routes[] = $routeDescriptor;
        }

        if ($categoryTag instanceof CategoryTag) {
            $category = $categoryTag->getCategoryName();
            if (!isset($this->routeCategories[$category])) {
                $this->routeCategories[$category] = [];
            }
            $routeDescriptor->category = $category;
            $this->routeCategories[$category][] = $routeDescriptor;
        } else {
            $routeDescriptor->category = '';
            $this->routes[] = $routeDescriptor;
        }
    }
}
