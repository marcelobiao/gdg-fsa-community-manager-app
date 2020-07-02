<?php

namespace App\Exceptions;

use App\Exceptions\BaseException;

class PeopleException extends BaseException
{
    const PEOPLE_NOT_FOUND = 0;

    protected $response =[
        PeopleException::PEOPLE_NOT_FOUND => 'People not found'
    ];
}
