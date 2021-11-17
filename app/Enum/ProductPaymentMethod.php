<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class ProductPaymentMethod extends Enum
{
    public const NORMAL       = 1;
    public const SAFE_PAYMENT = 2;
}
