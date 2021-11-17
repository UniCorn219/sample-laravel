<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsPromotionPrice
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $price_range
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsPromotionPrice newModelQuery()
 * @method static Builder|StatisticsPromotionPrice newQuery()
 * @method static Builder|StatisticsPromotionPrice query()
 * @method static Builder|StatisticsPromotionPrice whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionPrice whereId($value)
 * @method static Builder|StatisticsPromotionPrice whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionPrice wherePriceRange($value)
 * @method static Builder|StatisticsPromotionPrice whereStatisticsDate($value)
 * @method static Builder|StatisticsPromotionPrice whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionPrice whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsPromotionPrice extends AbstractModel
{
    protected $table = 'statistics_promotion_price';

    protected $fillable = [
        'statistics_date',
        'price_range',
        'localinfo_id',
        'total_clicks',
    ];
}
