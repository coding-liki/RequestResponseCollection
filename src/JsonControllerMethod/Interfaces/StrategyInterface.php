<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Request;

interface StrategyInterface
{
    public function setRequest(Request $request): static;
    public function setJsonArray(array $jsonArray): static;

    public function getController(): ?ControllerInterface;

    public function getMethod(): ?string;

    public function parseRequest();
}