<?php

namespace CodingLiki\RequestResponseCollection\Basic\Exceptions;

class CannotGetObjectPropertyException extends \Exception
{

    /**
     * @param object $object
     * @param string $name
     */
    public function __construct(private object $object, string $name)
    {
        parent::__construct("Object has not getter for $name and $name is not public");
    }

    /**
     * @return object
     */
    public function getObject(): object
    {
        return $this->object;
    }
}