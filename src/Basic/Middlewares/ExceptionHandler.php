<?php

namespace CodingLiki\RequestResponseCollection\Basic\Middlewares;

use CodingLiki\RequestResponseSystem\Middleware\BaseMiddleware;

class ExceptionHandler extends BaseMiddleware
{
    public function after(): void
    {
        if($this->throwable !== null) {
            echo "\nWe have throwable `".$this->throwable::class."` \n";
            echo "in file ".$this->throwable->getFile(). " on line ".$this->throwable->getLine()."\n";
            print_r($this->throwable->getTrace());

            if($this->request !== null){
                print_r($this->request);
            }

            if($this->response !== null){
                print_r($this->response);
            }
        }
    }
}