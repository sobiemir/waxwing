<?php
namespace Waxwing\Interfaces;

interface ApplicationRoutingInterface
{
    function setRouting(callable $callback, string $cacheFile = null): void;
}
