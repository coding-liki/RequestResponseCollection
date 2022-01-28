<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;

class Response implements InternalResponseInterface
{
    public function __construct( private string $body = "", private int $code = 200)
    {
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
}