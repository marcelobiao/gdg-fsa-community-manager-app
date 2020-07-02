<?php

namespace App\Exceptions;

use App\Exceptions\BaseException;

class EventException extends BaseException
{
    const EVENT_NOT_FOUND = 0;

    protected $response =[
        EventException::EVENT_NOT_FOUND => 'Event not found'
    ];
}
