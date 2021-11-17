<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionKeyword
 *
 * @property int $id
 * @property string $statistics_date
 * @property string $keyword
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsTransactionKeyword newModelQuery()
 * @method static Builder|StatisticsTransactionKeyword newQuery()
 * @method static Builder|StatisticsTransactionKeyword query()
 * @method static Builder|StatisticsTransactionKeyword whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionKeyword whereId($value)
 * @method static Builder|StatisticsTransactionKeyword whereKeyword($value)
 * @method static Builder|StatisticsTransactionKeyword whereTransactionId($value)
 * @method static Builder|StatisticsTransactionKeyword whereStatisticsDate($value)
 * @method static Builder|StatisticsTransactionKeyword whereTotalClicks($value)
 * @method static Builder|StatisticsTransactionKeyword whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsTransactionKeyword extends AbstractModel
{
    protected $table = 'statistics_transaction_keyword';

    protected $fillable = [
        'statistics_date',
        'keyword',
        'transaction_id',
        'total_clicks',
    ];
}