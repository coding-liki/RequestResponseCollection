<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod;

use CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonCannotInitPropertyException;
use CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonPropertyDoesNotExistException;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\ControllerInterface;
use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\StrategyInterface;
use CodingLiki\RequestResponseCollection\SimpleJson\Request as JsonRequest;
use JsonException;
use Psr\Http\Message\ServerRequestInterface;

class Request extends JsonRequest
{
    private ?ControllerInterface $controller = null;
    private ?string $method = null;
    private bool $parsed = false;

    /**
     * @param StrategyInterface[] $strategies
     * @throws JsonCannotInitPropertyException
     * @throws JsonPropertyDoesNotExistException
     * @throws JsonException
     */
    public function __construct(ServerRequestInterface $serverRequest, private array $strategies)
    {
        parent::__construct($serverRequest);
    }


    public function parseServerRequest()
    {
        $parsedBody = json_decode($this->getServerRequest()->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $acceptedStrategy = null;
        foreach ($this->strategies as $strategy) {
            $this->controller = $strategy
                ->setRequest($this)
                ->setJsonArray($parsedBody)
                ->getController();

            $this->method = $strategy->getMethod();
            if ($this->controller !== null && $this->method !== null) {
                $acceptedStrategy = $strategy;
                break;
            }
        }

        if ($acceptedStrategy !== null) {
            $acceptedStrategy->parseRequest();
            if($this->checkControllerMethod()) {
                $this->parsed = true;
            }
        }
    }

    public function getController(): ?ControllerInterface
    {
        return $this->controller;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @return bool
     */
    public function isParsed(): bool
    {
        return $this->parsed;
    }

    private function checkControllerMethod(): bool
    {
        return $this->controller->checkMethod($this->method, $this);
    }

}