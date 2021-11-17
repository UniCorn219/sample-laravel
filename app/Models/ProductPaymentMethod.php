<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\ProductPaymentMethod
 *
 * @property int $id
 * @property int $product_id
 * @property int $payment_method
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProductPaymentMethod newModelQuery()
 * @method static Builder|ProductPaymentMethod newQuery()
 * @method static Builder|ProductPaymentMethod query()
 * @method static Builder|ProductPaymentMethod whereCreatedAt($value)
 * @method static Builder|ProductPaymentMethod whereId($value)
 * @method static Builder|ProductPaymentMethod wherePaymentMethod($value)
 * @method static Builder|ProductPaymentMethod whereProductId($value)
 * @method static Builder|ProductPaymentMethod whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductPaymentMethod extends AbstractModel
{
    protected $table = 'product_payment_methods';

    protected $fillable = [
        'product_id',
        'payment_method',
    ];
}
