<?php

namespace Waxwing\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ActionInterface
{
    public function initialize(ActionDescriptorInterface $descriptor): void;
    public function execute(): ResponseInterface;
    public function getActionDescriptor(): ActionDescriptorInterface;
}
