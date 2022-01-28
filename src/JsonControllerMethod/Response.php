<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod;

use CodingLiki\RequestResponseCollection\Basic\Exceptions\CannotGetObjectPropertyException;
use CodingLiki\RequestResponseCollection\Basic\Json\ObjectConverter;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;

class Response implements InternalResponseInterface
{
    private int $code = 200;
    /**
     * @throws CannotGetObjectPropertyException
     */
    public function getArray(): array
    {
        $converter = new ObjectConverter($this);

        return $converter->toArray();
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}