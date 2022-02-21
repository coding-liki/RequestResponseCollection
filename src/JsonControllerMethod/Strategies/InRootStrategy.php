<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Strategies;

use CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonCannotInitPropertyException;
use CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonPropertyDoesNotExistException;
use CodingLiki\RequestResponseCollection\Basic\Json\ObjectInitializer;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\ControllerInterface;

/**
 * Ожидаем json вида {
 *  "controller": "controllerName",
 *  "method": "methodName",
 *  "params": {} // requestParams object
 * }
 * только поле params парсится в запрос
 */
class InRootStrategy extends BaseStrategy
{
    public function getController(): ?ControllerInterface
    {
        $controllerName = $this->jsonArray['controller'] ?? '';
        return $this->controllerFinder->find($controllerName);
    }

    public function getMethod(): ?string
    {
        return $this->jsonArray['method'] ?? null;
    }

    /**
     * @throws JsonPropertyDoesNotExistException
     * @throws JsonCannotInitPropertyException
     */
    public function parseRequest()
    {
        $params = $this->jsonArray['params'] ?? [];
        $initializer = new ObjectInitializer($this->request);
        $initializer->fromArray($params);
    }
}