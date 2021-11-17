<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class PromotionStatus extends Enum
{
    public const WAITING_FOR_APPROVAL = 1;
    public const IN_PROGRESS          = 2;
    public const REJECT_APPROVAL      = 3;
    public const FINISHED             = 4;
}
