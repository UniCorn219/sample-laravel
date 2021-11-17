<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionWeekly
 *
 * @property int $id
 * @property int $year_week
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsTransactionWeekly newModelQuery()
 * @method static Builder|StatisticsTransactionWeekly newQuery()
 * @method static Builder|StatisticsTransactionWeekly query()
 * @method static Builder|StatisticsTransactionWeekly whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionWeekly whereId($value)
 * @method static Builder|StatisticsTransactionWeekly whereTransactionId($value)
 * @method static Builder|StatisticsTransactionWeekly whereTotalClicks($value)
 * @method static Builder|StatisticsTransactionWeekly whereUpdatedAt($value)
 * @method static Builder|StatisticsTransactionWeekly whereYearWeek($value)
 * @mixin Eloquent
 */
class StatisticsTransactionWeekly extends AbstractModel
{
    protected $table = 'statistics_transaction_weekly';

    protected $fillable = [
        'year_week',
        'transaction_id',
        'total_clicks',
    ];
}