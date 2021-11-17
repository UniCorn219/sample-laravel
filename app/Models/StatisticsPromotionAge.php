<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsPromotionAge
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $age_range
 * @property int $total_posts
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsPromotionAge newModelQuery()
 * @method static Builder|StatisticsPromotionAge newQuery()
 * @method static Builder|StatisticsPromotionAge query()
 * @method static Builder|StatisticsPromotionAge whereAgeRange($value)
 * @method static Builder|StatisticsPromotionAge whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionAge whereId($value)
 * @method static Builder|StatisticsPromotionAge whereStatisticsDate($value)
 * @method static Builder|StatisticsPromotionAge whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionAge whereTotalPosts($value)
 * @method static Builder|StatisticsPromotionAge whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsPromotionAge extends AbstractModel
{
    protected $table = 'statistics_promotion_age';

    protected $fillable = [
        'statistics_date',
        'age_range',
        'total_posts',
        'total_clicks',
    ];
}