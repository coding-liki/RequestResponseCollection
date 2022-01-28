<?php

namespace CodingLiki\RequestResponseCollection\Basic\Exceptions;

class JsonPropertyDoesNotExistException extends \Exception
{
    public function __construct(private string $property, private string $targetClass)
    {
        parent::__construct("Property {$property} does not exist in class {$targetClass}");
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @return string
     */
    public function getTargetClass(): string
    {
        return $this->targetClass;
    }
}