<?php

namespace CodingLiki\RequestResponseCollection\Basic;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\RequestExtractorRegistrarInterface;
use CodingLiki\RequestResponseSystem\RequestExtractor\RequestExtractorInterface;

class RequestExtractorsInitializer
{
    /**
     * @param RequestExtractorRegistrarInterface[] $requestExtractorRegistrars
     */
    public function __construct(private array $requestExtractorRegistrars)
    {
    }

    /**
     * @return RequestExtractorInterface[]
     */
    public function init(): array
    {
        return array_map(function (RequestExtractorRegistrarInterface $registrar): RequestExtractorInterface {
            return $registrar->register();
        }, $this->requestExtractorRegistrars);
    }
}