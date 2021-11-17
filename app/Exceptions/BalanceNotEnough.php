<?php

namespace App\Exceptions;

class BalanceNotEnough extends BusinessException
{
    protected int $exceptionCode = 1000;
}
