<?php

namespace App\Exceptions;

class ThreadDoesNotBelongToUserException extends BusinessException
{
    protected $code    = 400;
    protected $message = 'thread_does_not_belong_to_user';
}
