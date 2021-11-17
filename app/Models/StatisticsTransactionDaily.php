<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionDaily
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsTransactionDaily newModelQuery()
 * @method static Builder|StatisticsTransactionDaily newQuery()
 * @method static Builder|StatisticsTransactionDaily query()
 * @method static Builder|StatisticsTransactionDaily whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionDaily whereId($value)
 * @method static Builder|StatisticsTransactionDaily whereTransactionId($value)
 * @method static Builder|StatisticsTransactionDaily whereStatisticsDate($value)
 * @method static Builder|StatisticsTransactionDaily whereTotalClicks($value)
 * @method static Builder|StatisticsTransactionDaily whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsTransactionDaily extends AbstractModel
{
    protected $table = 'statistics_transaction_daily';

    protected $fillable = [
        'statistics_date',
        'transaction_id',
        'total_clicks',
    ];
}