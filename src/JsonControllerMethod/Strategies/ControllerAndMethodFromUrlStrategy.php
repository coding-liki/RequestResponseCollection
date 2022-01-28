<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Strategies;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\ControllerInterface;

/**
 * Имя контроллера соответствует пути из uri запроса кроме последнего элемента.
 * Последний элемент является именем метода
 * Пример:
 *  /some/controller/method - имя контроллера '/some/controller', имя метода 'method'
 * Ожидаем json вида {
 * }
 *
 * ВЕсь json парсится в запрос
 */
class ControllerAndMethodFromUrlStrategy extends ControllerFromUrlStrategy
{

    public function getController(): ?ControllerInterface
    {
        $path = trim(trim($this->request->getServerRequest()->getUri()->getPath()), '\/');
        $parts = explode('/', $path);
        array_pop($parts);
        return $this->controllerFinder->find(strtolower(implode('/', $parts)));
    }

    public function getMethod(): ?string
    {
        $parts = explode('/', $this->request->getServerRequest()->getUri()->getPath());

        $method = end($parts);

        return $method ? strtolower($method) : NULL;
    }
}