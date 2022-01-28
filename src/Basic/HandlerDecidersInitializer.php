<?php

namespace CodingLiki\RequestResponseCollection\Basic;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\HandlerDeciderRegistrarInterface;
use CodingLiki\RequestResponseSystem\HandlerDecider\HandlerDeciderInterface;

class HandlerDecidersInitializer
{
    /**
     * @param HandlerDeciderRegistrarInterface[] $handlerDeciderRegistrars
     */
    public function __construct(private array $handlerDeciderRegistrars)
    {
    }

    /**
     * @return HandlerDeciderInterface[]
     */
    public function init(): array
    {
        return array_map(function (HandlerDeciderRegistrarInterface $registrar): HandlerDeciderInterface {
            return $registrar->register();
        }, $this->handlerDeciderRegistrars);
    }
}