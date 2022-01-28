<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\HandlerDeciderRegistrarInterface;
use CodingLiki\RequestResponseSystem\HandlerDecider\HandlerDeciderInterface;

class HandlerDeciderRegistrar implements HandlerDeciderRegistrarInterface
{
    public function __construct(private array $handlers)
    {
    }

    public function register(): HandlerDeciderInterface
    {
        return new HandlerDecider($this->handlers);
    }
}