<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Strategies;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\ControllerInterface;

/**
 * Имя контроллера соответствует пути из uri запроса.
 * Ожидаем json вида {
 *  "method": "methodName",
 *  "params": {} // requestParams object
 * }
 *
 * только поле params парсится в запрос
 */
class ControllerFromUrlStrategy extends InRootStrategy
{

    public function getController(): ?ControllerInterface
    {
        return $this->controllerFinder->find($this->request->getServerRequest()->getUri()->getPath());
    }



}