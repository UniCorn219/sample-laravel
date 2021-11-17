<?php

namespace App\Models;

use App\Casts\AmountCast;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * \App\Models\TransferTransactionable
 *
 * @property int $id
 * @property int $user_id
 * @property int $bank_id
 * @property AmountCast $amount
 * @property int|null $applied_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|TransferTransactionable newModelQuery()
 * @method static Builder|TransferTransactionable newQuery()
 * @method static Builder|TransferTransactionable query()
 * @method static Builder|TransferTransactionable whereAmount($value)
 * @method static Builder|TransferTransactionable whereAppliedBy($value)
 * @method static Builder|TransferTransactionable whereBankId($value)
 * @method static Builder|TransferTransactionable whereCreatedAt($value)
 * @method static Builder|TransferTransactionable whereId($value)
 * @method static Builder|TransferTransactionable whereUpdatedAt($value)
 * @method static Builder|TransferTransactionable whereUserId($value)
 * @mixin Eloquent
 */
class TransferTransactionable extends AbstractModel
{
    protected $table = 'transfer_transactionable';

    protected $fillable = [
        'user_id',
        'bank_id',
        'amount',
        'applied_by',
    ];

    protected $casts = [
        'amount' => AmountCast::class,
    ];

    public function transaction(): MorphOne
    {
        return $this->morphOne(PointTransaction::class, 'transactionable');
    }
}
