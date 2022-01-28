<?php

namespace CodingLiki\RequestResponseCollection\Basic\Attributes;

use Attribute;

#[Attribute(flags: Attribute::IS_REPEATABLE| Attribute::TARGET_CLASS)]
class Path
{
    public function __construct(public string $uri)
    {
    }
}