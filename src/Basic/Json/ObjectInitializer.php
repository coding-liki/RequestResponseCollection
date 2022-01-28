<?php

namespace CodingLiki\RequestResponseCollection\Basic\Json;

use CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonCannotInitPropertyException;
use CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonPropertyDoesNotExistException;

class ObjectInitializer
{
    public function __construct(private object $rootObject, private bool $strict = true)
    {
    }

    /**
     * @throws JsonPropertyDoesNotExistException
     * @throws JsonCannotInitPropertyException
     */
    public function fromArray(array $jsonArray)
    {
        $this->initObject($this->rootObject, $jsonArray);
    }

    /**
     * @throws JsonPropertyDoesNotExistException
     * @throws JsonCannotInitPropertyException
     */
    private function initObject(object $object, array $jsonArray)
    {
        $refClass = new \ReflectionClass($object);
        foreach ($jsonArray as $name => $value) {
            $this->initProperty($object, $refClass, $name, $value);
        }
    }

    /**
     * @throws JsonPropertyDoesNotExistException
     * @throws JsonCannotInitPropertyException
     */
    private function initProperty(object $object, \ReflectionClass $refClass, string $name, mixed $value)
    {
        if (!$refClass->hasProperty($name)) {
            if ($this->strict) {
                throw new JsonPropertyDoesNotExistException($name, $refClass->getName());
            }

            return;
        }

        $refProperty = $refClass->getProperty($name);

        $value = $this->initValue($refProperty, $value);

        $isSet = $this->setValue($refProperty, $object, $value);

        if ($this->strict && !$isSet) {
            throw new JsonCannotInitPropertyException($name, $refClass->getName());
        }
    }

    /**
     * @param \ReflectionProperty $refProperty
     * @param mixed               $value
     *
     * @return mixed
     * @throws JsonCannotInitPropertyException
     * @throws JsonPropertyDoesNotExistException
     */
    private function initValue(\ReflectionProperty $refProperty, mixed $value): mixed
    {
        if (!$refProperty->getType()->isBuiltin()) {
            $class     = $refProperty->getType()->getName();
            $newObject = new $class();
            $this->initObject($newObject, $value);

            $value = $newObject;
        }

        return $value;
    }

    /**
     * @param \ReflectionProperty $refProperty
     * @param object              $object
     * @param mixed               $value
     *
     * @return bool
     */
    private function setValue(\ReflectionProperty $refProperty, object $object, mixed $value): bool
    {
        $name   = $refProperty->getName();
        $setter = 'set' . ucfirst($name);

        if ($refProperty->isPrivate() && $refProperty->getDeclaringClass()->hasMethod($setter)) {
            $object->$setter($value);

            return true;
        }
        if ($refProperty->isPublic()) {
            $object->$name = $value;

            return true;
        }

        return false;
    }
}