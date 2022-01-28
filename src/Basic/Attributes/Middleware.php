<?php

namespace CodingLiki\RequestResponseCollection\Basic\Attributes;

use Attribute;

#[Attribute]
class Middleware
{
    public function __construct(private string $middlewareClass, private array $params)
    {
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getMiddlewareClass(): string
    {
        return $this->middlewareClass;
    }

}