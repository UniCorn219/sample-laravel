<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected $code    = 500;
    protected $message = 'base_exception';
}
