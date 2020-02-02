<?php

namespace Waxwing\Interfaces;

interface ActionDescriptorInterface
{
    function setRenderers(array $renderers): void;
    function getRenderers(): array;
    function setUriParameters(array $parameters): void;
    function getUriParameters(): array;
    function setBodyDescriptor(string $class, bool $required = true, array $availableParsers = null): void;
    function getBodyParsers(): array;
    function getBodyClass(): string;
    function isBodyRequired(): bool;
}
