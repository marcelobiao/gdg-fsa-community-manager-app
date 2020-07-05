<?php

namespace App\Exceptions;

use App\Exceptions\BaseException;

class ImportException extends BaseException
{
    const IMPORT_NOT_FOUND = 0;

    protected $response =[
        ImportException::IMPORT_NOT_FOUND => 'Import not found'
    ];
}
