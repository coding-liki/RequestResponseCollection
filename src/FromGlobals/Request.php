<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use Psr\Http\Message\ServerRequestInterface;

class Request implements InternalRequestInterface
{
    public function __construct(private ServerRequestInterface $serverRequest)
    {
        $this->parseServerRequest();
    }

    public function getServerRequest(): ServerRequestInterface
    {
        return $this->serverRequest;
    }

    public function parseServerRequest()
    {
        $params = array_merge($this->serverRequest->getParsedBody(), $this->serverRequest->getQueryParams());
        foreach ($params as $name => $param) {
            $setter = "set".ucfirst($name);
            if(method_exists($this, $setter)){
                $this->$setter($param);
            }
        }
    }
}