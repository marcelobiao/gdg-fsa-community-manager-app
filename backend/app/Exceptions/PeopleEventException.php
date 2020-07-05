<?php

namespace App\Exceptions;

use App\Exceptions\BaseException;

class PeopleEventException extends BaseException
{
    const PEOPLE_EVENT_NOT_FOUND = 0;

    protected $response =[
        PeopleEventException::PEOPLE_EVENT_NOT_FOUND => 'People_Event not found'
    ];
}
