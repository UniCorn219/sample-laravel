<?php

namespace App\Exceptions;

class ResourceNotFoundException extends BusinessException
{
    protected $code    = 404;
    protected $message = 'resource_not_found';
}
