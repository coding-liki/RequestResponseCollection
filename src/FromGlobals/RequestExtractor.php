<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\RequestExtractor\RequestExtractorInterface;
use GuzzleHttp\Psr7\ServerRequest;

class RequestExtractor implements RequestExtractorInterface
{
    public function __construct(private array $requestMapper)
    {
    }

    public function extract(): ?InternalRequestInterface
    {
        $serverRequest = ServerRequest::fromGlobals();
        if(isset($this->requestMapper[$serverRequest->getUri()->getPath()])){
            $class = $this->requestMapper[$serverRequest->getUri()->getPath()];
            return new $class($serverRequest);
        }

        return NULL;
    }
}