<?php

namespace CodingLiki\RequestResponseCollection\Basic;

use CodingLiki\RequestResponseSystem\HandlerDeciderFabric;
use CodingLiki\RequestResponseSystem\RequestFabric;
use CodingLiki\RequestResponseSystem\ResponseProcessorFabric;
use CodingLiki\RequestResponseSystem\System;

class SystemInitializer
{
    public function __construct(
        private RequestExtractorsInitializer  $requestExtractorsInitializer,
        private HandlerDecidersInitializer    $handlerDecidersInitializer,
        private ResponseProcessorsInitializer $responseProcessorsInitializer,
        private MiddlewaresInitializer        $middlewaresInitializer
    )
    {
    }

    public function init(): System
    {
        $requestExtractors   = $this->requestExtractorsInitializer->init();
        $handlerDeciders     = $this->handlerDecidersInitializer->init();
        $responseProcessors  = $this->responseProcessorsInitializer->init();
        $middlewareContainer = $this->middlewaresInitializer->init();

        return new System(
            new RequestFabric($requestExtractors),
            new HandlerDeciderFabric($handlerDeciders),
            new ResponseProcessorFabric($responseProcessors),
            $middlewareContainer
        );
    }
}