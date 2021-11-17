<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class PointTransactionLogType extends Enum
{
    public const REQUEST_TRANSFER = 1;
    public const ACCEPT_TRANSFER  = 2;
    public const CREATE_PROMOTION = 3;
}
