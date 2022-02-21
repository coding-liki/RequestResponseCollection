<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Controllers;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Exceptions\MethodDoesNotExistsException;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Exceptions\NoRunMethodInActionException;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Request;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Response;

abstract class ActionController extends SimpleController
{
    private const ACTION_METHOD = 'run';
    public function getActions(): array
    {
        return [];
    }

    /**
     * @throws NoRunMethodInActionException
     * @throws MethodDoesNotExistsException
     */
    public function runMethod(string $method, Request $request): Response
    {
        try {
            return parent::runMethod($this->prepareMethodName($method), $request);
        } catch (MethodDoesNotExistsException $e){
            $actionClass = $this->getActions()[$method] ?? null;
            if($actionClass === null) {
                throw new MethodDoesNotExistsException($method, static::class);
            }

            $action = new $actionClass();
            if(!method_exists($action, self::ACTION_METHOD)) {
                throw new NoRunMethodInActionException($actionClass);
            }

            return $action->run($request);
        }
    }

    public function checkMethod(string $method, Request $request): bool
    {
        $actionClass = $this->getActions()[$method] ?? null;

        if($actionClass === null){
            return parent::checkMethod($this->prepareMethodName($method), $request);
        } else {
            $refClass = new \ReflectionClass($actionClass);
            if($refClass->hasMethod(self::ACTION_METHOD)){
                $refType = $refClass->getMethod(self::ACTION_METHOD)->getParameters()[0]->getType();

                return $this->checkType($refType, $request);
            }
        }

        return false;
    }

    /**
     * @param string $method
     * @return string
     */
    private function prepareMethodName(string $method): string
    {
        $parts = explode('-', $method);
        $parts = array_map('ucfirst', $parts);
        return "action" . implode('', $parts);
    }
}