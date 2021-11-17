<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * App\Models\StatisticsUserMonthlyActivity
 *
 * @property int $id
 * @property int $year_month
 * @property int $user_id
 * @property int $total_activities
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $month
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity whereTotalActivities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserMonthlyActivity whereYearMonth($value)
 * @mixin \Eloquent
 */
class StatisticsUserMonthlyActivity extends AbstractModel
{
    protected $table = 'statistics_user_monthly_activities';

    protected $fillable = [
        'year_month',
        'user_id',
        'total_activities',
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
