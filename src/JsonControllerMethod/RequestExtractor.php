<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod;

use CodingLiki\RequestResponseCollection\JsonControllerMethod\Interfaces\StrategyInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\RequestExtractor\RequestExtractorInterface;
use GuzzleHttp\Psr7\ServerRequest;

class RequestExtractor implements RequestExtractorInterface
{
    /**
     * @param string[]            $requestClasses
     * @param StrategyInterface[] $strategies
     */
    public function __construct(private array $requestClasses, private array $strategies)
    {
    }

    /**
     * @throws \CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonPropertyDoesNotExistException
     * @throws \CodingLiki\RequestResponseCollection\Basic\Exceptions\JsonCannotInitPropertyException
     * @throws \JsonException
     */
    public function extract(): ?InternalRequestInterface
    {
        $serverRequest = ServerRequest::fromGlobals();
        foreach ($this->requestClasses as $requestClass) {
            if (is_a($requestClass, Request::class, true)) {
                /** @var Request $request */
                $request = new $requestClass($serverRequest, $this->strategies);
                if ($request->isParsed()) {
                    return $request;
                }
            }
        }

        return NULL;
    }
}