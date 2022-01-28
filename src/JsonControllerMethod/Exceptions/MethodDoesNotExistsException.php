<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Exceptions;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class MethodDoesNotExistsException extends \Exception
{
    public function __construct(string $method, string $controller)
    {
        parent::__construct("There is no method $method in controller $controller");
    }
}