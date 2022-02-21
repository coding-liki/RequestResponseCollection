<?php

namespace CodingLiki\RequestResponseCollection\Basic\Middlewares;

use CodingLiki\RequestResponseSystem\Middleware\BaseMiddleware;

#[\Attribute]
class AddCors extends BaseMiddleware
{
    public function __construct(private string $allowedCors = '*')
    {
    }

    public function before(): void
    {
        header('Access-Control-Allow-Origin: ' . $this->allowedCors);
        header('Access-Control-Allow-Headers: content-type');

    }
}