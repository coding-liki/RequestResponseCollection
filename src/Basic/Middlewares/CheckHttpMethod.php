<?php

namespace CodingLiki\RequestResponseCollection\Basic\Middlewares;

use CodingLiki\RequestResponseCollection\Basic\Exceptions\BadMethodException;
use CodingLiki\RequestResponseSystem\Middleware\BaseMiddleware;

#[\Attribute]
class CheckHttpMethod extends BaseMiddleware
{

    public function __construct(private string $method)
    {
    }

    /**
     * @throws BadMethodException
     */
    public function before(): void
    {
        if($this->request !== null) {
            $method = $this->request->getServerRequest()->getMethod();
            if(strtolower($method) !== strtolower($this->method)){
                throw new BadMethodException($this->method, $method);
            }
        }
    }
}