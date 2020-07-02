<?php

namespace App\Exceptions;

use Exception;

abstract class BaseException extends Exception
{
    //protected $response = [];

    public function __construct($code = 0, Exception $previous = null) {
        parent::__construct(
            array_key_exists($code,$this->response) ? $this->response[$code] : 'Erro Interno',
            $code,
            $previous);
    }
}
