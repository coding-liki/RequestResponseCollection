<?php

namespace CodingLiki\RequestResponseCollection\Basic\Exceptions;

class JsonCannotInitPropertyException extends \Exception
{
    public function __construct(private string $property, private string $targetClass)
    {
        parent::__construct("Cannot init property $property in class $targetClass");
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