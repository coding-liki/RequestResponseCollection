<?php

namespace CodingLiki\RequestResponseCollection\JsonControllerMethod;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\RequestExtractorRegistrarInterface;
use CodingLiki\RequestResponseCollection\Helper\ClassHelper;
use CodingLiki\RequestResponseSystem\RequestExtractor\RequestExtractorInterface;

class RequestExtractorRegistrar implements RequestExtractorRegistrarInterface
{
    public function __construct(private array $requestPaths, private array $strategies)
    {
    }

    public function register(): RequestExtractorInterface
    {
        $fullMap = [];
        foreach ($this->requestPaths as $path) {
            $fullMap += $this->searchInDirectory($path);
        }

        return new RequestExtractor(array_unique($fullMap), $this->strategies);
    }

    private function searchInDirectory(string $requestDirectory): array
    {
        $dirtyClasses = ClassHelper::getClassesFromDirectoryRecursive($requestDirectory);

        $map = [];
        foreach ($dirtyClasses as $class) {
            if (!is_a($class, Request::class, true)) {
                continue;
            }
            $map[] = $class;
        }
        return $map;
    }
}