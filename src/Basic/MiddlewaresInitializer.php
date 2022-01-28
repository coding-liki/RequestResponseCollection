<?php

namespace CodingLiki\RequestResponseCollection\Basic;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\MiddlewareRegistrarInterface;
use CodingLiki\RequestResponseSystem\Middleware\MiddlewareContainer;

class MiddlewaresInitializer
{
    /**
     * @param MiddlewareRegistrarInterface[] $middlewareRegistrars
     */
    public function __construct(private array $middlewareRegistrars)
    {

    }

    public function init(): MiddlewareContainer
    {
        $container = new MiddlewareContainer();

        foreach ($this->middlewareRegistrars as $registrar) {
            $registrar->register($container);
        }

        return $container;
    }
}