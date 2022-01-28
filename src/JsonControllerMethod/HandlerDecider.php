<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod;

use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\HandlerDecider\HandlerDeciderInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;

class HandlerDecider implements HandlerDeciderInterface
{
    /**
     * @param HandlerInterface[] $handlers
     */
    public function __construct(private array $handlers)
    {
    }

    public function canProcessRequest(InternalRequestInterface $request): bool
    {
        return $request instanceof Request;
    }

    public function getHandler(InternalRequestInterface $request): ?HandlerInterface
    {
        foreach ($this->handlers as $handler) {
            if($handler->accepts($request)){
                return $handler;
            }
        }

        return NULL;
    }
}