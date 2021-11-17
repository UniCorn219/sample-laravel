<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsPromotionHourly
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $statistics_hour
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsPromotionHourly newModelQuery()
 * @method static Builder|StatisticsPromotionHourly newQuery()
 * @method static Builder|StatisticsPromotionHourly query()
 * @method static Builder|StatisticsPromotionHourly whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionHourly whereId($value)
 * @method static Builder|StatisticsPromotionHourly whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionHourly whereStatisticsDate($value)
 * @method static Builder|StatisticsPromotionHourly whereStatisticsHour($value)
 * @method static Builder|StatisticsPromotionHourly whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionHourly whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsPromotionHourly extends AbstractModel
{
    protected $table = 'statistics_promotion_hourly';

    protected $fillable = [
        'statistics_date',
        'statistics_hour',
        'localinfo_id',
        'total_clicks',
    ];
}