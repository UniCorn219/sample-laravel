<?php

namespace App\Models;

use App\Casts\AmountCast;
use App\ValueObjects\Amount;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\PromotionTransactionable
 *
 * @property int $id
 * @property int $actor_id
 * @property int $promotion_id
 * @property int $type
 * @property Amount $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PromotionTransactionable newModelQuery()
 * @method static Builder|PromotionTransactionable newQuery()
 * @method static Builder|PromotionTransactionable query()
 * @method static Builder|PromotionTransactionable whereActorId($value)
 * @method static Builder|PromotionTransactionable whereAmount($value)
 * @method static Builder|PromotionTransactionable whereCreatedAt($value)
 * @method static Builder|PromotionTransactionable whereId($value)
 * @method static Builder|PromotionTransactionable wherePromotionId($value)
 * @method static Builder|PromotionTransactionable whereType($value)
 * @method static Builder|PromotionTransactionable whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PromotionTransactionable extends AbstractModel
{
    protected $table = 'promotion_transactionable';

    protected $fillable = [
        'actor_id',
        'promotion_id',
        'type',
        'amount',
    ];

    protected $casts = [
        'amount' => AmountCast::class,
    ];
}
