<?php

namespace App\Models;

use App\Casts\AmountCast;
use App\ValueObjects\Amount;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\PaymentTransaction
 *
 * @property int $id
 * @property string|null $order_id
 * @property int $transactionable_id
 * @property string $transactionable_type
 * @property int $status
 * @property Amount $amount
 * @property int $amount_type
 * @property float $amount_rate
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent $transactionable
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction newQuery()
 * @method static Builder|PaymentTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereAmountRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereAmountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereTransactionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereTransactionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereUpdatedAt($value)
 * @method static Builder|PaymentTransaction withTrashed()
 * @method static Builder|PaymentTransaction withoutTrashed()
 * @mixin Eloquent
 */
class PaymentTransaction extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'payment_transactions';

    protected $fillable = [
        'order_id',
        'transactionable_id',
        'transactionable_type',
        'status',
        'amount',
        'amount_type',
        'amount_rate',
    ];

    protected $casts = [
        'amount' => AmountCast::class,
    ];

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
