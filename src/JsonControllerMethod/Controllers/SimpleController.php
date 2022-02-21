<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Controllers;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Exceptions\MethodDoesNotExistsException;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\ControllerInterface;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Request;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Response;

class SimpleController implements ControllerInterface
{
    public function runMethod(string $method, Request $request): Response
    {
        if (!method_exists($this, $method)) {
            throw new MethodDoesNotExistsException($method, static::class);
        }

        return $this->$method($request);
    }

    public function checkMethod(string $method, Request $request): bool
    {
        $refObject = new \ReflectionObject($this);

        if ($refObject->hasMethod($method)) {
            $parameterType = $refObject->getMethod($method)->getParameters()[0]->getType();

            return $this->checkType($parameterType, $request);
        }

        return false;
    }

    protected function checkType(\ReflectionIntersectionType|\ReflectionUnionType|\ReflectionNamedType|null $parameterType, Request $request): bool
    {
        $fullTypes = [];
        if ($parameterType instanceof \ReflectionNamedType) {
            $fullTypes[] = $parameterType->getName();
        } else {
            foreach ($parameterType->getTypes() as $type) {
                $fullTypes[] = $type->getName();
            }
        }

        foreach ($fullTypes as $type) {
            if (is_a($request, $type)) {
                return true;
            }
        }

        return false;
    }
}