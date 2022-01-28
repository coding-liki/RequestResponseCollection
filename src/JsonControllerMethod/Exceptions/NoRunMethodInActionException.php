<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Exceptions;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class NoRunMethodInActionException extends \Exception
{
    public function __construct(string $action)
    {
        parent::__construct("There is no method run in action $action");
    }
}