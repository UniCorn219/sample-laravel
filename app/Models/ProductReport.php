<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductReport
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string $content
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport newQuery()
 * @method static Builder|ProductReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReport whereUserId($value)
 * @method static Builder|ProductReport withTrashed()
 * @method static Builder|ProductReport withoutTrashed()
 * @mixin Eloquent
 */
class ProductReport extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public $table = 'product_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'content',
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
