<?php

namespace App\Models;

/**
 * App\Models\StatisticsUserDailyClick
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $user_id
 * @property int $total_clicks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick whereStatisticsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick whereTotalClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserDailyClick whereUserId($value)
 * @mixin \Eloquent
 */
class StatisticsUserDailyClick extends AbstractModel
{
    protected $table = 'statistics_user_daily_click';

    protected $fillable = [
        'statistics_date',
        'user_id',
        'total_clicks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
