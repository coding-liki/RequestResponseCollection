<?php

namespace CodingLiki\RequestResponseCollection\Basic\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Json
{
    public function __construct(private ?string $name = NULL)
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}