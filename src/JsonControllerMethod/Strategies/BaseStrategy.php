<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod\Strategies;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\ControllerFinderInterface;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\StrategyInterface;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Request;

abstract class BaseStrategy implements StrategyInterface
{
    protected Request $request;
    protected array $jsonArray;

    public function __construct(protected ControllerFinderInterface $controllerFinder)
    {
    }

    public function setRequest(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function setJsonArray(array $jsonArray): static
    {
        $this->jsonArray = $jsonArray;

        return $this;
    }


}