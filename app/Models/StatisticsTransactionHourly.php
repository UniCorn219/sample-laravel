<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionHourly
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $statistics_hour
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsTransactionHourly newModelQuery()
 * @method static Builder|StatisticsTransactionHourly newQuery()
 * @method static Builder|StatisticsTransactionHourly query()
 * @method static Builder|StatisticsTransactionHourly whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionHourly whereId($value)
 * @method static Builder|StatisticsTransactionHourly whereTransactionId($value)
 * @method static Builder|StatisticsTransactionHourly whereStatisticsDate($value)
 * @method static Builder|StatisticsTransactionHourly whereStatisticsHour($value)
 * @method static Builder|StatisticsTransactionHourly whereTotalClicks($value)
 * @method static Builder|StatisticsTransactionHourly whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsTransactionHourly extends AbstractModel
{
    protected $table = 'statistics_transaction_hourly';

    protected $fillable = [
        'statistics_date',
        'statistics_hour',
        'transaction_id',
        'total_clicks',
    ];
}