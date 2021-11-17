<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class TransactionStatus extends Enum
{
    public const PROCESSING = 1;
    public const SUCCEEDED  = 2;
    public const FAILED     = 3;
    public const CANCELLED  = 4; // sender cancel it
    public const REJECTED   = 5; // recipient reject it
    public const REFUNDED   = 6; // system refund
}
