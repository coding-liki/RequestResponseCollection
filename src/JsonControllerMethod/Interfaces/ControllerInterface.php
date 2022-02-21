<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Request;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Response;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;

interface ControllerInterface
{
    public function runMethod(string $method, Request $request): Response;

    public function checkMethod(string $method, Request $request): bool;
}