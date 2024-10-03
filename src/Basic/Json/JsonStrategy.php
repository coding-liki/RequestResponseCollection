<?php

namespace CodingLiki\RequestResponseCollection\Basic\Json;

trait JsonStrategy
{
    private ?string $jsonStrategy = NULL;

    public function setJsonStrategy(?string $jsonStrategy): static
    {
        $this->jsonStrategy = $jsonStrategy;
        return $this;
    }

    public function getJsonStrategy(): ?string
    {
        return $this->jsonStrategy;
    }
}