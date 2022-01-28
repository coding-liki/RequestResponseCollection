<?php

namespace CodingLiki\RequestResponseCollection\Basic\Interfaces;

use CodingLiki\RequestResponseSystem\Middleware\MiddlewareContainer;

interface MiddlewareRegistrarInterface
{
    public function register(MiddlewareContainer $container): void;
}