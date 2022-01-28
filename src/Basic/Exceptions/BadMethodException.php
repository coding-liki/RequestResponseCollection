<?php

namespace CodingLiki\RequestResponseCollection\Basic\Exceptions;


class BadMethodException extends \Exception
{
    public function __construct(string $requestMethod, string $needMethod)
    {
        parent::__construct("method need to be `$needMethod`, but found `$requestMethod`");
    }
}