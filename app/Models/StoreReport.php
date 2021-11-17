<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\StoreReport
 *
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|StoreReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreReport newQuery()
 * @method static Builder|StoreReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreReport query()
 * @method static Builder|StoreReport withTrashed()
 * @method static Builder|StoreReport withoutTrashed()
 * @mixin Eloquent
 */
class StoreReport extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'store_id',
        'reason',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
