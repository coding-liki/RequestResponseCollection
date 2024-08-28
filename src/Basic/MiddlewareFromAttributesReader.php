<?php

namespace CodingLiki\RequestResponseCollection\Basic;

use CodingLiki\RequestResponseCollection\Basic\Attributes\Middleware;
use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\Middleware\MiddlewareContainer;
use CodingLiki\RequestResponseSystem\Middleware\MiddlewareInterface;

class MiddlewareFromAttributesReader
{
    public function __construct(private MiddlewareContainer $container)
    {
    }

    public function read(string|object $subject)
    {
        $this->processMiddlewareAttributes($subject);

        $this->checkMiddlewaresAsAttributes($subject);
    }

    private function processMiddlewareAttributes(object|string $subject): void
    {
        $refClass = new \ReflectionClass($subject);

        $middlewareAttributes = $refClass->getAttributes(Middleware::class);
        $middlewaresToAdd = [];
        foreach ($middlewareAttributes as $attribute) {
            /** @var Middleware $instance */
            $instance = $attribute->newInstance();
            $middlewareClass = $instance->getMiddlewareClass();
            $middlewaresToAdd[] = new $middlewareClass(...$instance->getParams());
        }

        $this->addMiddlewares($subject, $middlewaresToAdd);
    }

    private function checkMiddlewaresAsAttributes(object|string $subject): void
    {
        $refClass = new \ReflectionClass($subject);

        $middlewareAttributes = $refClass->getAttributes(MiddlewareInterface::class, \ReflectionAttribute::IS_INSTANCEOF);

        $middlewaresToAdd = [];
        foreach ($middlewareAttributes as $attribute) {
            $middlewaresToAdd[] = $attribute->newInstance();
        }

        $this->addMiddlewares($subject, $middlewaresToAdd);
    }

    /**
     * @param object|string $subject
     * @param array $middlewaresToAdd
     *
     * @return void
     */
    private function addMiddlewares(object|string $subject, array $middlewaresToAdd): void
    {
        if (is_a($subject, HandlerInterface::class, true)) {

            $this->container->addByHandlerClass(is_string($subject) ? $subject : $subject::class, $middlewaresToAdd);
        }

        if (is_a($subject, InternalRequestInterface::class, true)) {

            $this->container->addByRequestClass(is_string($subject) ? $subject : $subject::class, $middlewaresToAdd);
        }
    }
}