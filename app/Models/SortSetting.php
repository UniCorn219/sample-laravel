<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\SortSetting
 *
 * @property int $id
 * @property int $product_sort_option 1:Newest,2:Like,3:View,4:Manually
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SortSetting newModelQuery()
 * @method static Builder|SortSetting newQuery()
 * @method static Builder|SortSetting query()
 * @method static Builder|SortSetting whereCreatedAt($value)
 * @method static Builder|SortSetting whereId($value)
 * @method static Builder|SortSetting whereProductSortOption($value)
 * @method static Builder|SortSetting whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SortSetting extends AbstractModel
{
    use HasFactory;

    const PRODUCT_NEWEST_SORT = 1;
    const PRODUCT_TOTAL_LIKE_SORT = 2;
    const PRODUCT_TOTAL_VIEW_SORT = 3;
    const PRODUCT_ADMIN_SORT = 4;

    const PRODUCT_SORT_OPTIONS = [
        self::PRODUCT_NEWEST_SORT,
        self::PRODUCT_TOTAL_LIKE_SORT,
        self::PRODUCT_TOTAL_VIEW_SORT,
        self::PRODUCT_ADMIN_SORT,
    ];

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'product_sort_option',
        'created_at',
        'updated_at',
    ];
}
