<?php

namespace Waxwing\Interfaces;

interface ActionDescriptorInterface
{
    function setUriParameters(array $parameters): void;
    function getUriParameters(): array;
    function setBodyDescriptor(string $class, bool $required = true, array $availableParsers = null): void;
    function getBodyParsers(): array;
    function getBodyClass(): string;
    function isBodyRequired(): bool;
    function setResponseDescriptor(string $class, int $responseCode = 200, array $availableRenderers = null): void;
    function getResponseRenderers(): array;
    function getResponseClass(): string;
    function getResponseCode(): int;
}
