<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionAge
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $age_range
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsTransactionAge newModelQuery()
 * @method static Builder|StatisticsTransactionAge newQuery()
 * @method static Builder|StatisticsTransactionAge query()
 * @method static Builder|StatisticsTransactionAge whereAgeRange($value)
 * @method static Builder|StatisticsTransactionAge whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionAge whereId($value)
 * @method static Builder|StatisticsTransactionAge whereStatisticsDate($value)
 * @method static Builder|StatisticsTransactionAge whereTransactionId($value)
 * @method static Builder|StatisticsTransactionAge whereTotalPosts($value)
 * @method static Builder|StatisticsTransactionAge whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsTransactionAge extends AbstractModel
{
    protected $table = 'statistics_transaction_age';

    protected $fillable = [
        'statistics_date',
        'age_range',
        'transaction_id',
        'total_clicks',
    ];
}