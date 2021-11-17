<?php

namespace App\Models;

/**
 * App\Models\StatisticsUserActivity
 *
 * @property int $id
 * @property string $statistics_date
 * @property int $user_id
 * @property int $total_activities
 * @property int $total_likes
 * @property int $total_product
 * @property int $total_product_complete
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereStatisticsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereTotalActivities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereTotalLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereTotalProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereTotalProductComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatisticsUserActivity whereUserId($value)
 * @mixin \Eloquent
 */
class StatisticsUserActivity extends AbstractModel
{
    protected $table = 'statistics_user_activities';

    protected $fillable = [
        'statistics_date',
        'user_id',
        'total_activities',
        'total_likes',
        'total_product',
        'total_product_complete',
    ];
}
