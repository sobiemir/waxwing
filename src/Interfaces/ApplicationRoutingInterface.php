<?php

namespace Waxwing\Interfaces;

interface ApplicationRoutingInterface
{
    public function setRouting(ApplicationRoutingCallbackInterface $callback, string $cacheFile = null): void;
}
