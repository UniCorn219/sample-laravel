<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class PointTransactionStatus extends Enum
{
    public const WAITING = 1;
    public const SUCCESS = 2;
    public const FAILURE = 3;
}
