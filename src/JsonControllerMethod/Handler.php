<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod;

use CodingLiki\RequestResponseSystem\Exceptions\NoHandlerForRequestException;
use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;


class Handler implements HandlerInterface
{
    private InternalRequestInterface $request;

    public function accepts(InternalRequestInterface $request): bool
    {
        return $request instanceof Request;
    }

    public function setRequest(InternalRequestInterface $request): static
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest(): mixed
    {
        return $this->request;
    }

    /**
     * @throws NoHandlerForRequestException
     */
    public function run(Request $request): Response
    {
        $controller = $request->getController();
        $method = $request->getMethod();

        if($controller !== null && $method !== null){
          return $controller->runMethod($method, $request);
        }

        throw new NoHandlerForRequestException($request);
    }
}