<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\ResponseProcessorInterface;

class ResponseProcessor implements ResponseProcessorInterface
{

    public function canProcess(InternalResponseInterface $response): bool
    {
        return $response instanceof Response;
    }

    /**
     * @param Response $response
     *
     * @return void
     */
    public function process(InternalResponseInterface $response)
    {
        http_response_code($response->getCode());
        echo $response->getBody();

    }
}