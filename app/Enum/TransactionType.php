<?php
namespace App\Enum;

use BenSampo\Enum\Enum;

class TransactionType extends Enum
{
    const ONLINE = 1;
    const OFFLINE = 2;
    const BOTH = 3;
}
