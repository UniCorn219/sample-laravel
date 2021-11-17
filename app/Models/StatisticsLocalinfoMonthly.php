<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsLocalinfoMonthly
 *
 * @property int $id
 * @property int $year_month
 * @property int $localinfo_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsLocalinfoMonthly newModelQuery()
 * @method static Builder|StatisticsLocalinfoMonthly newQuery()
 * @method static Builder|StatisticsLocalinfoMonthly query()
 * @method static Builder|StatisticsLocalinfoMonthly whereCreatedAt($value)
 * @method static Builder|StatisticsLocalinfoMonthly whereId($value)
 * @method static Builder|StatisticsLocalinfoMonthly whereLocalinfoId($value)
 * @method static Builder|StatisticsLocalinfoMonthly whereTotalClicks($value)
 * @method static Builder|StatisticsLocalinfoMonthly whereUpdatedAt($value)
 * @method static Builder|StatisticsLocalinfoMonthly whereYearMonth($value)
 * @mixin Eloquent
 */
class StatisticsLocalinfoMonthly extends AbstractModel
{
    protected $table = 'statistics_localinfo_monthly';

    protected $fillable = [
        'year_month',
        'localinfo_id',
        'total_clicks',
    ];
}