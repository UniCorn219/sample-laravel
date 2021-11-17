<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionAmount
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $amount_range
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsTransactionAmount newModelQuery()
 * @method static Builder|StatisticsTransactionAmount newQuery()
 * @method static Builder|StatisticsTransactionAmount query()
 * @method static Builder|StatisticsTransactionAmount whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionAmount whereId($value)
 * @method static Builder|StatisticsTransactionAmount whereTransactionId($value)
 * @method static Builder|StatisticsTransactionAmount whereAmountRange($value)
 * @method static Builder|StatisticsTransactionAmount whereStatisticsDate($value)
 * @method static Builder|StatisticsTransactionAmount whereTotalClicks($value)
 * @method static Builder|StatisticsTransactionAmount whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsTransactionAmount extends AbstractModel
{
    protected $table = 'statistics_transaction_amount';

    protected $fillable = [
        'statistics_date',
        'amount_range',
        'transaction_id',
        'total_clicks',
    ];
}
