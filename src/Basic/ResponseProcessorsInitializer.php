<?php

namespace CodingLiki\RequestResponseCollection\Basic;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\ResponseProcessorRegistrarInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\ResponseProcessorInterface;

class ResponseProcessorsInitializer
{
    /**
     * @param ResponseProcessorRegistrarInterface[] $responseProcessorRegistrars
     */
    public function __construct(private array $responseProcessorRegistrars)
    {
    }

    /**
     * @return ResponseProcessorInterface[]
     */
    public function init(): array
    {
        return array_map(function (ResponseProcessorRegistrarInterface $registrar): ResponseProcessorInterface {
            return $registrar->register();
        }, $this->responseProcessorRegistrars);
    }
}