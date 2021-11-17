<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class PointTransactionType extends Enum
{
    public const TRANSFER         = 'transfer_bank';
    public const CREATE_PROMOTION = 'create_promotion';
}
