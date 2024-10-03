<?php

namespace CodingLiki\RequestResponseCollection\Basic\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
readonly class Json
{
    /**
     * @param string|null $name - The name of the property in the json representation. If NULL then name of then property itself.
     * @param array $strategies - Strategies in witch this property will be represented. Use with CodingLiki\RequestResponseCollection\Basic\Json\JsonStrategy .
     */
    public function __construct(public ?string $name = NULL, public array $strategies = [])
    {
    }
}