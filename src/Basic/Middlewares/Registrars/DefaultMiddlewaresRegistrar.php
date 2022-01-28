<?php

namespace CodingLiki\RequestResponseCollection\Basic\Middlewares\Registrars;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\MiddlewareRegistrarInterface;
use CodingLiki\RequestResponseSystem\Middleware\MiddlewareContainer;
use CodingLiki\RequestResponseSystem\Middleware\MiddlewareInterface;

class DefaultMiddlewaresRegistrar implements MiddlewareRegistrarInterface
{
    /**
     * @param MiddlewareInterface[] $requestMiddlewares
     * @param MiddlewareInterface[] $handlerMiddlewares
     */
    public function __construct(private array $requestMiddlewares, private array $handlerMiddlewares)
    {
    }

    public function register(MiddlewareContainer $container): void
    {
        $container
            ->addByRequestClass(NULL, $this->requestMiddlewares)
            ->addByHandlerClass(NULL, $this->handlerMiddlewares);
    }
}