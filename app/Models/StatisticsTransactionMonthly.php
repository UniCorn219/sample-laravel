<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionMonthly
 *
 * @property int $id
 * @property int $year_month
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsTransactionMonthly newModelQuery()
 * @method static Builder|StatisticsTransactionMonthly newQuery()
 * @method static Builder|StatisticsTransactionMonthly query()
 * @method static Builder|StatisticsTransactionMonthly whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionMonthly whereId($value)
 * @method static Builder|StatisticsTransactionMonthly whereTransactionId($value)
 * @method static Builder|StatisticsTransactionMonthly whereTotalClicks($value)
 * @method static Builder|StatisticsTransactionMonthly whereUpdatedAt($value)
 * @method static Builder|StatisticsTransactionMonthly whereYearMonth($value)
 * @mixin Eloquent
 */
class StatisticsTransactionMonthly extends AbstractModel
{
    protected $table = 'statistics_transaction_monthly';

    protected $fillable = [
        'year_month',
        'transaction_id',
        'total_clicks',
    ];
}