<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces;

interface ControllerFinderInterface
{
    public function find(string $controllerName): ?ControllerInterface;
}