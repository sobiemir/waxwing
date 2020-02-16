<?php

namespace Waxwing\Routes;

final class RouteDescriptor
{
    /** @var string */
    public $method;
    /** @var string */
    public $route;
    /** @var string[] */
    public $routeVariables;
    /** @var string */
    public $action;
    /** @var bool */
    public $isBodyRequired;
    /** @var string */
    public $bodyClass;
    /** @var string */
    public $responseClass;
    /** @var int */
    public $responseCode;
    /** @var RouteParameterDescriptor[] */
    public $parameters;
    /** @var string */
    public $category;
}
