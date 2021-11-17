<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionLocation
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $area_id
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Area $area
 * @method static Builder|StatisticsTransactionLocation newModelQuery()
 * @method static Builder|StatisticsTransactionLocation newQuery()
 * @method static Builder|StatisticsTransactionLocation query()
 * @method static Builder|StatisticsTransactionLocation whereAreaId($value)
 * @method static Builder|StatisticsTransactionLocation whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionLocation whereId($value)
 * @method static Builder|StatisticsTransactionLocation whereTransactionId($value)
 * @method static Builder|StatisticsTransactionLocation whereStatisticsDate($value)
 * @method static Builder|StatisticsTransactionLocation whereTotalClicks($value)
 * @method static Builder|StatisticsTransactionLocation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsTransactionLocation extends AbstractModel
{
    protected $table = 'statistics_transaction_location';

    protected $fillable = [
        'statistics_date',
        'area_id',
        'transaction_id',
        'total_clicks',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}