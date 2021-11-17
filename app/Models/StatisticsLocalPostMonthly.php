<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalPostMonthly
 *
 * @property int $id
 * @property int $year_month
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsPromotionMonthly newModelQuery()
 * @method static Builder|StatisticsPromotionMonthly newQuery()
 * @method static Builder|StatisticsPromotionMonthly query()
 * @method static Builder|StatisticsPromotionMonthly whereCreatedAt($value)
 * @method static Builder|StatisticsPromotionMonthly whereId($value)
 * @method static Builder|StatisticsPromotionMonthly whereLocalinfoId($value)
 * @method static Builder|StatisticsPromotionMonthly whereTotalClicks($value)
 * @method static Builder|StatisticsPromotionMonthly whereUpdatedAt($value)
 * @method static Builder|StatisticsPromotionMonthly whereYearMonth($value)
 * @mixin Eloquent
 */
class StatisticsLocalPostMonthly extends AbstractModel
{
    protected $table = 'statistics_localpost_monthly';

    protected $fillable = [
        'year_month',
        'localpost_id',
        'total_clicks',
    ];
}
