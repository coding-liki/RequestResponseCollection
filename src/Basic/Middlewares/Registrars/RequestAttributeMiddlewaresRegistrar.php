<?php

namespace CodingLiki\RequestResponseCollection\Basic\Middlewares\Registrars;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\MiddlewareRegistrarInterface;
use CodingLiki\RequestResponseCollection\Basic\MiddlewareFromAttributesReader;
use CodingLiki\RequestResponseCollection\Helper\ClassHelper;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\Middleware\MiddlewareContainer;

class RequestAttributeMiddlewaresRegistrar implements MiddlewareRegistrarInterface
{
    public function __construct(private array $requestClasses)
    {
    }

    public function register(MiddlewareContainer $container): void
    {
        $reader = new MiddlewareFromAttributesReader($container);
        foreach ($this->requestClasses as $requestClass) {
            $reader->read($requestClass);
        }
    }

    public static function getByDirectory(string $requestDirectory): static
    {
        $requestDirtyClasses = ClassHelper::getClassesFromDirectoryRecursive($requestDirectory);

        $requestClasses = [];
        foreach ($requestDirtyClasses as $class) {
            if (is_a($class, InternalRequestInterface::class, true)) {
                $requestClasses[] = (new \ReflectionClass($class))->getName();
            }
        }

        return new static($requestClasses);
    }
}