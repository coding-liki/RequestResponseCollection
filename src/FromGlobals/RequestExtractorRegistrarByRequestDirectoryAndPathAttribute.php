<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseCollection\Basic\Attributes\Path;
use CodingLiki\RequestResponseCollection\Basic\Interfaces\RequestExtractorRegistrarInterface;
use CodingLiki\RequestResponseCollection\Helper\ClassHelper;
use CodingLiki\RequestResponseSystem\InternalRequestInterface;
use CodingLiki\RequestResponseSystem\RequestExtractor\RequestExtractorInterface;

class RequestExtractorRegistrarByRequestDirectoryAndPathAttribute implements RequestExtractorRegistrarInterface
{
    /**
     * @param string[] $requestDirectories
     */
    public function __construct(private array $requestDirectories)
    {
    }

    public function register(): RequestExtractorInterface
    {
        return new RequestExtractor($this->buildRequestMap());
    }

    private function buildRequestMap(): array
    {
        $map = [];
        foreach ($this->requestDirectories as $requestDirectory) {
            $map = array_merge($map, $this->searchInDirectory($requestDirectory));
        }

        return $map;
    }

    private function searchInDirectory(string $requestDirectory): array
    {
        $dirtyClasses = ClassHelper::getClassesFromDirectoryRecursive($requestDirectory);

        $map = [];
        foreach ($dirtyClasses as $class) {
            if(!is_a($class, InternalRequestInterface::class, true)){
                continue;
            }

            $refClass = new \ReflectionClass($class);

            $attributes = $refClass->getAttributes(Path::class, \ReflectionAttribute::IS_INSTANCEOF);
            foreach ($attributes as $attribute) {
                /** @var Path $instance */
                $instance = $attribute->newInstance();
                $map[$instance->uri] =  $refClass->getName();
            }
        }

        return $map;
    }
}