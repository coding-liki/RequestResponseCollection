<?php

namespace CodingLiki\RequestResponseCollection\SimpleJson;

use CodingLiki\RequestResponseCollection\Basic\Json\ObjectInitializer;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use Psr\Http\Message\ServerRequestInterface;

class Request implements InternalRequestInterface
{
    /**
     * @throws \CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonPropertyDoesNotExistException
     * @throws \CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonCannotInitPropertyException
     * @throws \JsonException
     */
    public function __construct(private ServerRequestInterface $serverRequest)
    {
        $this->parseServerRequest();
    }

    public function getServerRequest(): ServerRequestInterface
    {
        return $this->serverRequest;
    }

    /**
     * @throws \CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonCannotInitPropertyException
     * @throws \CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonPropertyDoesNotExistException
     * @throws \JsonException
     */
    public function parseServerRequest()
    {
        $parsedBody = json_decode($this->serverRequest->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $objectInitializer = new ObjectInitializer($this, true);
        $objectInitializer->fromArray($parsedBody);
    }
}