<?php

namespace App\Exceptions;

use Throwable;

class BusinessException extends BaseException
{
    protected $code    = 400;
    protected $message = 'business_exception';
    protected int $exceptionCode = 400;

    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        $this->exceptionCode = $code;
        parent::__construct($message, 400, $previous);
    }

    public function getExceptionCode(): int
    {
        return $this->exceptionCode;
    }
}
