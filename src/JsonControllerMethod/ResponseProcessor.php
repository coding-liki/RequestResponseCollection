<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod;

use CodingLiki\RequestResponseCollection\Basic\Exceptions\CannotGetObjectPropertyException;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\ResponseProcessorInterface;

class ResponseProcessor implements ResponseProcessorInterface
{

    public function canProcess(InternalResponseInterface $response): bool
    {
        return $response instanceof Response;
    }

    /**
     * @param Response $response
     *
     * @return void
     * @throws CannotGetObjectPropertyException
     */
    public function process(InternalResponseInterface $response)
    {
        http_response_code($response->getCode());

        $responseArray = $response->getArray();

        echo json_encode($responseArray);
    }
}