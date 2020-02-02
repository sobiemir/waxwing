<?php

namespace Waxwing\Interfaces;

interface ApplicationRoutingInterface
{
    function setRouting(ApplicationRoutingCallbackInterface $callback, string $cacheFile = null): void;
}
