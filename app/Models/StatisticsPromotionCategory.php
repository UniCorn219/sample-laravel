<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsPromotionCategory
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $category_id
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @method static Builder|StatisticsPromotionCategory newModelQuery()
 * @method static Builder|StatisticsPromotionCategory newQuery()
 * @method static Builder|StatisticsPromotionCategory query()
 * @method static Builder|StatisticsPromotionCategory whereCategoryId($value)
 * @method static Builder|StatisticsPromotionCategory whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionCategory whereId($value)
 * @method static Builder|StatisticsPromotionCategory whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionCategory whereStatisticsDate($value)
 * @method static Builder|StatisticsPromotionCategory whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsPromotionCategory extends AbstractModel
{
    protected $table = 'statistics_promotion_category';

    protected $fillable = [
        'statistics_date',
        'category_id',
        'localinfo_id',
        'total_clicks',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}