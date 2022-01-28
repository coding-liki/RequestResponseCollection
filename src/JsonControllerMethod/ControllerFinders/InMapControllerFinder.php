<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\ControllerFinders;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\ControllerFinderInterface;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\ControllerInterface;

class InMapControllerFinder implements ControllerFinderInterface
{
    /**
     * @param array<string, ControllerInterface> $map
     */
    public function __construct(private array $map)
    {
    }

    public function find(string $controllerName): ?ControllerInterface
    {
        return $this->map[$controllerName] ?? NULL;
    }
}