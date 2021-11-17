<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StatisticsTransactionCategory
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $category_id
 * @property int $transaction_id
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 * @method static Builder|StatisticsTransactionCategory newModelQuery()
 * @method static Builder|StatisticsTransactionCategory newQuery()
 * @method static Builder|StatisticsTransactionCategory query()
 * @method static Builder|StatisticsTransactionCategory whereCategoryId($value)
 * @method static Builder|StatisticsTransactionCategory whereCreatedAt($value)
 * @method static Builder|StatisticsTransactionCategory whereId($value)
 * @method static Builder|StatisticsTransactionCategory whereTransactionId($value)
 * @method static Builder|StatisticsTransactionCategory whereStatisticsDate($value)
 * @method static Builder|StatisticsTransactionCategory whereTotalClicks($value)
 * @method static Builder|StatisticsTransactionCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsTransactionCategory extends AbstractModel
{
    protected $table = 'statistics_transaction_category';

    protected $fillable = [
        'statistics_date',
        'category_id',
        'transaction_id',
        'total_clicks',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}