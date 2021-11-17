<?php

namespace App\Models;

use App\Casts\AmountCast;
use App\ValueObjects\Amount;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\PointTransactionLog
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $type
 * @property int|null $actor_id
 * @property int|null $user_id
 * @property Amount $amount
 * @property Amount $balance_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PointTransactionLog newModelQuery()
 * @method static Builder|PointTransactionLog newQuery()
 * @method static Builder|PointTransactionLog query()
 * @method static Builder|PointTransactionLog whereActorId($value)
 * @method static Builder|PointTransactionLog whereAmount($value)
 * @method static Builder|PointTransactionLog whereBalanceAmount($value)
 * @method static Builder|PointTransactionLog whereCreatedAt($value)
 * @method static Builder|PointTransactionLog whereId($value)
 * @method static Builder|PointTransactionLog whereTransactionId($value)
 * @method static Builder|PointTransactionLog whereType($value)
 * @method static Builder|PointTransactionLog whereUpdatedAt($value)
 * @method static Builder|PointTransactionLog whereUserId($value)
 * @mixin Eloquent
 */
class PointTransactionLog extends AbstractModel
{
    protected $table = 'point_transaction_logs';

    protected $fillable = [
        'transaction_id',
        'type',
        'actor_id',
        'user_id',
        'amount',
        'balance_amount',
    ];

    protected $casts = [
        'amount'         => AmountCast::class,
        'balance_amount' => AmountCast::class,
    ];
}
