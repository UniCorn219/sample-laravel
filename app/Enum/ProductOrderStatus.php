<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class ProductOrderStatus extends Enum
{
    public const PROCESSING       = 1;
    public const ACCEPTED         = 2;
    public const REJECTED         = 3;
    public const SENT_LOGISTICS   = 4;
    public const CANCELLED        = 5;
    public const RECEIVED_PRODUCT = 6;
}
