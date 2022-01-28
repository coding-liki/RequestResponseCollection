<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\RequestExtractorRegistrarInterface;
use CodingLiki\RequestResponseSystem\RequestExtractor\RequestExtractorInterface;

class RequestExtractorRegistrarFromArray implements RequestExtractorRegistrarInterface
{
    public function __construct(private array $requestMap)
    {
    }

    public function register(): RequestExtractorInterface
    {
        return new RequestExtractor($this->requestMap);
    }
}