<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\ResponseProcessorRegistrarInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\ResponseProcessorInterface;

class ResponseProcessorRegistrar implements ResponseProcessorRegistrarInterface
{

    public function register(): ResponseProcessorInterface
    {
        return new ResponseProcessor();
    }
}