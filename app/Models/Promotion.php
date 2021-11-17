<?php

namespace App\Models;

use App\Enum\PromotionStatus;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\Promotion
 *
 * @property int $id
 * @property int $localinfo_id
 * @property int $price
 * @property int $total_user
 * @property Carbon|null $expired_at
 * @property int $status
 * @property int $created_by
 * @property Carbon|null $rejected_at
 * @property int|null $rejected_by
 * @property Carbon|null $accepted_at
 * @property int|null $accepted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion newQuery()
 * @method static Builder|Promotion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereAcceptedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereLocalinfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereRejectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereRejectedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereTotalUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereUpdatedAt($value)
 * @method static Builder|Promotion withTrashed()
 * @method static Builder|Promotion withoutTrashed()
 * @mixin Eloquent
 * @property int $total_promoted_user
 * @property int $count_day
 * @property string|null $reject_reason
 * @property-read Collection|Area[] $areas
 * @property-read int|null $areas_count
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read LocalInfo $localinfo
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereCountDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereTotalPromotedUser($value)
 * @property string|null $accept_reason
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion available()
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereAcceptReason($value)
 */
class Promotion extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'promotions';

    protected $fillable = [
        'localinfo_id',
        'price',
        'total_user',
        'total_promoted_user',
        'count_day',
        'status',
        'created_by',
        'rejected_at',
        'rejected_by',
        'reject_reason',
        'accepted_at',
        'accepted_by',
    ];

    protected $dates = [
        'expired_at',
        'rejected_at',
        'accepted_at',
    ];

    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(
            Area::class,
            'promotion_area',
            'promotion_id',
            'area_id')
            ->withTimestamps();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'promotion_category',
            'promotion_id',
            'category_id')
            ->withTimestamps();
    }

    public function localinfo(): BelongsTo
    {
        return $this->belongsTo(LocalInfo::class, 'localinfo_id');
    }

    public function scopeAvailable($query)
    {
        $query->where('status', PromotionStatus::IN_PROGRESS)
            ->whereRaw("accepted_at + (interval '1' day * count_day) >= now()")
            ->whereColumn('total_user', '>', 'total_promoted_user');
    }
}
