<?php

namespace App\Exceptions;

class MaxStoreReachedException extends BusinessException
{
    protected $code    = 400;
    protected $message = 'max_store_reached';
}
