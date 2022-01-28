<?php

namespace CodingLiki\RequestResponseCollection\Basic\Attributes;

use Attribute;

#[Attribute(flags: Attribute::IS_REPEATABLE| Attribute::TARGET_CLASS)]
class Handle
{
    /**
     * @param string[] $requestClasses
     */
    public function __construct(public array|string $requestClasses)
    {
    }
}