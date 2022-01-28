<?php

namespace CodingLiki\RequestResponseCollection\Basic\Json;

use CodingLiki\RequestResponseCollection\Basic\Attributes\Json;
use CodingLiki\RequestResponseCollection\Basic\Exceptions\CannotGetObjectPropertyException;

class ObjectConverter
{
    public function __construct(private object $rootObject)
    {
    }

    /**
     * @throws CannotGetObjectPropertyException
     */
    public function toArray(): array
    {
        return $this->getArrayFromObject($this->rootObject);
    }

    /**
     * @throws CannotGetObjectPropertyException
     */
    private function getArrayFromObject(object $object): array
    {
        $refClass   = new \ReflectionClass($this->rootObject);
        $properties = $refClass->getProperties();
        $result     = [];
        foreach ($properties as $property) {
            $this->processProperty($object, $property, $result);
        }

        return $result;
    }

    /**
     * @throws CannotGetObjectPropertyException
     */
    private function processProperty(object $object, \ReflectionProperty $property, array &$result)
    {
        $attribute = $property->getAttributes(Json::class)[0] ?? NULL;
        if ($attribute === NULL) {
            return;
        }
        /** @var Json $attributeInstance */
        $attributeInstance = $attribute->newInstance();
        $jsonPropertyName  = $attributeInstance->getName() ?? $property->getName() ;

        $value = $this->getObjectProperty($object, $property->getName(), $property->isPrivate());

        if ($property->getType()->isBuiltin()) {
            $result[$jsonPropertyName] = $value;
        } else {
            $result[$jsonPropertyName] = $this->getArrayFromObject($value);
        }
    }

    /**
     * @throws CannotGetObjectPropertyException
     */
    private function getObjectProperty(object $object, string $name, bool $isPrivate): mixed
    {
        try {
            if ($isPrivate) {
                $getter = 'get' . ucfirst($name);

                return $object->$getter();
            } else {
                return $object->$name;
            }
        } catch (\Throwable $t) {
            throw new CannotGetObjectPropertyException($object, $name);
        }
    }
}