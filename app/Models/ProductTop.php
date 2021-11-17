<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductLike
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLike newQuery()
 * @method static Builder|ProductLike onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLike query()
 * @method static Builder|ProductLike withTrashed()
 * @method static Builder|ProductLike withoutTrashed()
 * @mixin Eloquent
 */
class ProductTop extends AbstractModel
{
    use HasFactory;

    public $timestamps = true;

    public $table = 'product_tops';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'product_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function actionNotifications()
    {
        return $this->morphMany(NotificationObject::class, 'entityAction');
    }
}
