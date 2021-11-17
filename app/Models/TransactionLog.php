<?php

namespace App\Models;

use App\Casts\AmountCast;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\TransactionLog
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $transaction_status
 * @property int|null $actor_id
 * @property string|null $actor_type
 * @property int|null $user_id
 * @property string $amount
 * @property int $amount_type
 * @property float $amount_rate
 * @property mixed|null $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|TransactionLog newModelQuery()
 * @method static Builder|TransactionLog newQuery()
 * @method static Builder|TransactionLog query()
 * @method static Builder|TransactionLog whereActorId($value)
 * @method static Builder|TransactionLog whereActorType($value)
 * @method static Builder|TransactionLog whereAmount($value)
 * @method static Builder|TransactionLog whereAmountRate($value)
 * @method static Builder|TransactionLog whereAmountType($value)
 * @method static Builder|TransactionLog whereCreatedAt($value)
 * @method static Builder|TransactionLog whereId($value)
 * @method static Builder|TransactionLog wherePayload($value)
 * @method static Builder|TransactionLog whereTransactionId($value)
 * @method static Builder|TransactionLog whereTransactionStatus($value)
 * @method static Builder|TransactionLog whereUpdatedAt($value)
 * @method static Builder|TransactionLog whereUserId($value)
 * @mixin Eloquent
 */
class TransactionLog extends AbstractModel
{
    protected $table = 'transaction_logs';

    protected $fillable = [
        'transaction_id',
        'transaction_status',
        'actor_id',
        'actor_type',
        'user_id',
        'amount',
        'amount_type',
        'amount_rate',
        'payload',
    ];

    protected $casts = [
        'amount' => AmountCast::class,
    ];
}
