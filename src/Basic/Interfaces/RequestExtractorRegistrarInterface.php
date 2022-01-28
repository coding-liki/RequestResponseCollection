<?php

namespace CodingLiki\RequestResponseCollection\Basic\Interfaces;

use CodingLiki\RequestResponseSystem\RequestExtractor\RequestExtractorInterface;

interface RequestExtractorRegistrarInterface
{
    public function register(): RequestExtractorInterface;
}