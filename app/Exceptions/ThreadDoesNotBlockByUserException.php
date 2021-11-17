<?php

namespace App\Exceptions;

class ThreadDoesNotBlockByUserException extends BusinessException
{
    protected $code    = 400;
    protected $message = 'thread_does_not_block_by_user';
}
