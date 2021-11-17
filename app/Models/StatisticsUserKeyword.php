<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatisticsUserKeyword
 *
 * @property int $id
 * @property string $statistics_date
 * @property string $keyword
 * @property int $total_users
 * @property int $total_clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StatisticsUserKeyword newModelQuery()
 * @method static Builder|StatisticsUserKeyword newQuery()
 * @method static Builder|StatisticsUserKeyword query()
 * @method static Builder|StatisticsUserKeyword whereCreatedAt($value)
 * @method static Builder|StatisticsUserKeyword whereId($value)
 * @method static Builder|StatisticsUserKeyword whereKeyword($value)
 * @method static Builder|StatisticsUserKeyword whereStatisticsDate($value)
 * @method static Builder|StatisticsUserKeyword whereTotalClicks($value)
 * @method static Builder|StatisticsUserKeyword whereTotalUsers($value)
 * @method static Builder|StatisticsUserKeyword whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StatisticsUserKeyword extends AbstractModel
{
    protected $attributes = [
        'statistics_date',
        'keyword',
        'total_users',
        'total_clicks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
