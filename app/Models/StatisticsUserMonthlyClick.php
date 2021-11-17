<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * App\Models\StatisticsUserMonthlyClick
 *
 * @property int $id
 * @property int $year_month
 * @property int $user_id
 * @property int $total_clicks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $month
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick whereTotalClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyClick whereYearMonth($value)
 * @mixin \Eloquent
 */
class StatisticsUserMonthlyClick extends AbstractModel
{
    protected $table = 'statistics_user_monthly_click';

    protected $fillable = [
        'year_month',
        'user_id',
        'total_clicks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'month'
    ];

    public function getMonthAttribute(): string
    {
        $yearMonth = $this->getAttribute('year_month');
        Carbon::setLocale('en');
        
        return Carbon::createFromFormat('Ym', $yearMonth)->shortMonthName;
    }
}
