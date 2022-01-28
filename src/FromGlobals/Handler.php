<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseCollection\Basic\Attributes\Handle;
use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\ResponseProcessor\InternalResponseInterface;

/**
 * @template requestClass
 */
abstract class Handler implements HandlerInterface
{
    private InternalRequestInterface $request;

    /** @var string[] */
    private array $requestClasses = [];

    public function accepts(InternalRequestInterface $request): bool
    {
        if ($this->requestClasses === []) {
            $refClass = new \ReflectionClass(static::class);

            $attributes = $refClass->getAttributes(Handle::class, \ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                /** @var Handle $instance */
                $instance = $attribute->newInstance();
                is_array($instance->requestClasses) ?? $instance->requestClasses = [$instance->requestClasses];
                $this->requestClasses = array_merge($this->requestClasses, $instance->requestClasses);
            }
        }

        print_r($this->requestClasses);
        return in_array($request::class, $this->requestClasses);
    }

    public function setRequest(InternalRequestInterface $request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return requestClass
     */
    public function getRequest(): InternalRequestInterface
    {
        return $this->request;
    }

    abstract public function run(): InternalResponseInterface;
}