<?php

namespace App\Enum;

use App\Models\ProductTransactionable;
use App\Models\PromotionTransactionable;
use App\Models\TransferTransactionable;
use BenSampo\Enum\Enum;
use Illuminate\Database\Eloquent\Relations\Relation;

class TransactionableType extends Enum
{
    public const PRODUCT   = 'product';
    public const TRANSFER  = 'transfer_bank';
    public const PROMOTION = 'promotion';

    public static function morphMap()
    {
        Relation::morphMap([
            self::PRODUCT   => ProductTransactionable::class,
            self::TRANSFER  => TransferTransactionable::class,
            self::PROMOTION => PromotionTransactionable::class,
        ]);
    }
}
