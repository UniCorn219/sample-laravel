<?php

namespace App\Models;

use App\Casts\AmountCast;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\PointTransaction
 *
 * @property int $id
 * @property int $transactionable_id
 * @property string $transactionable_type
 * @property int $status
 * @property AmountCast $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PointTransaction newModelQuery()
 * @method static Builder|PointTransaction newQuery()
 * @method static Builder|PointTransaction query()
 * @method static Builder|PointTransaction whereAmount($value)
 * @method static Builder|PointTransaction whereCreatedAt($value)
 * @method static Builder|PointTransaction whereId($value)
 * @method static Builder|PointTransaction whereStatus($value)
 * @method static Builder|PointTransaction whereTransactionableId($value)
 * @method static Builder|PointTransaction whereTransactionableType($value)
 * @method static Builder|PointTransaction whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PointTransaction extends AbstractModel
{
    protected $table = 'point_transactions';

    protected $fillable = [
        'transactionable_id',
        'transactionable_type',
        'status',
        'amount',
    ];

    protected $casts = [
        'amount' => AmountCast::class,
    ];

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
