<?php

namespace CodingLiki\RequestResponseCollection\Basic\Interfaces;

use CodingLiki\RequestResponseSystem\ResponseProcessor\ResponseProcessorInterface;

interface ResponseProcessorRegistrarInterface
{
    public function register(): ResponseProcessorInterface;

}