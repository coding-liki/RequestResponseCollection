<?php

namespace CodingLiki\RequestResponseCollection\FromGlobals;

use CodingLiki\RequestResponseCollection\Basic\Interfaces\HandlerDeciderRegistrarInterface;
use CodingLiki\RequestResponseCollection\Helper\ClassHelper;
use CodingLiki\RequestResponseSystem\Handler\HandlerInterface;
use CodingLiki\RequestResponseSystem\HandlerDecider\HandlerDeciderInterface;

class HandlerDeciderRegistrarByHandlersDirectory implements HandlerDeciderRegistrarInterface
{
    /**
     * @param string[] $handlerDirectories
     */
    public function __construct(private array $handlerDirectories)
    {
    }

    public function register(): HandlerDeciderInterface
    {
        $handlers = [];

        foreach ($this->handlerDirectories as $directory){
            $handlers = array_merge($handlers, $this->searchInDirectory($directory));
        }

        return new HandlerDecider($handlers);
    }

    /**
     * @param string $directory
     *
     * @return HandlerInterface[]
     */
    private function searchInDirectory(string $directory): array
    {
        $classes = ClassHelper::getClassesFromDirectoryRecursive($directory);

        $handlers = [];
        foreach ($classes as $class){
            if(is_a($class, Handler::class,true)){
                $handlers[] = new $class();
            }
        }

        return $handlers;
    }
}