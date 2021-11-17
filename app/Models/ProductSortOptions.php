<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductSortOptions
 *
 * @property int $id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|ProductSortOptions newModelQuery()
 * @method static Builder|ProductSortOptions newQuery()
 * @method static Builder|ProductSortOptions query()
 * @method static Builder|ProductSortOptions whereCreatedAt($value)
 * @method static Builder|ProductSortOptions whereId($value)
 * @method static Builder|ProductSortOptions whereProductId($value)
 * @method static Builder|ProductSortOptions whereUpdatedAt($value)
 * @method static Builder|ProductSortOptions whereDeletedAt($value)
 * @mixin Eloquent
 */
class ProductSortOptions extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $hidden = [
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'product_id',
    ];
}
