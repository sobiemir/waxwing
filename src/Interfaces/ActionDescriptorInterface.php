<?php

namespace Waxwing\Interfaces;

interface ActionDescriptorInterface
{
    public function setUriParameters(array $parameters): void;
    public function getUriParameters(): array;
    public function setBodyDescriptor(?string $class, bool $required = true, array $availableParsers = null): void;
    public function getBodyParsers(): array;
    public function getBodyClass(): string;
    public function isBodyRequired(): bool;
    public function setResponseDescriptor(?string $class, int $responseCode = 200, array $availableRenderers = null): void;
    public function getResponseRenderers(): array;
    public function getResponseClass(): string;
    public function getResponseCode(): int;
}
