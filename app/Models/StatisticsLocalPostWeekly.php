<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalPostWeekly
 *
 * @property int $id
 * @property int $year_week
 * @property int $localpost_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsPromotionWeekly newModelQuery()
 * @method static Builder|StatisticsPromotionWeekly newQuery()
 * @method static Builder|StatisticsPromotionWeekly query()
 * @method static Builder|StatisticsPromotionWeekly whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionWeekly whereId($value)
 * @method static Builder|StatisticsPromotionWeekly whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionWeekly whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionWeekly whereUpdatedAt($value)
 * @method static Builder|StatisticsPromotionWeekly whereYearWeek($value)
 * @mixin Eloquent
 */
class StatisticsLocalPostWeekly extends AbstractModel
{
    protected $table = 'statistics_localpost_weekly';

    protected $fillable = [
        'year_week',
        'localpost_id',
        'total_clicks',
    ];
}
