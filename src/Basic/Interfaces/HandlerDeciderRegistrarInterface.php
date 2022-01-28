<?php

namespace CodingLiki\RequestResponseCollection\Basic\Interfaces;

use CodingLiki\RequestResponseSystem\HandlerDecider\HandlerDeciderInterface;

interface HandlerDeciderRegistrarInterface
{
    public function register(): HandlerDeciderInterface;

}