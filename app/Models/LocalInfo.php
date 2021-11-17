<?php

namespace App\Models;

use App\Enum\PromotionStatus;
use App\Enum\UserActionableType;
use Eloquent;
use Exception;
use Geometry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use geoPHP;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Log;

/**
 * App\Models\LocalInfo
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property int $store_id
 * @property string|null $title
 * @property string|null $content
 * @property float|null $price
 * @property string $location
 * @property int|null $emd_area_id
 * @property int $total_like
 * @property int $total_review
 * @property string|null $url_share_post
 * @property string|null $url_share_address
 * @property bool $accept_chat
 * @property string|null $phone
 * @property int|null $total_search
 * @property int|null $total_view
 * @property int|null $status
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 * @property-read Collection|LocalInfoLike[] $commentLikes
 * @property-read int|null $comment_likes_count
 * @property-read EmdArea|null $emdArea
 * @property-read string $address
 * @property-read MorphOne|null $liked
 * @property-read Collection|Mediable[] $images
 * @property-read int|null $images_count
 * @property-read Collection|LocalInfoLike[] $likes
 * @property-read int|null $likes_count
 * @property-read Collection|LocalInfoReport[] $reports
 * @property-read int|null $reports_count
 * @property-read Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo newQuery()
 * @method static Builder|LocalInfo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereAcceptChat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereBoughtAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereBuyerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereEmdAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereTotalLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereTotalReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereUrlShareAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfo whereUrlSharePost($value)
 * @method static Builder|LocalInfo withTrashed()
 * @method static Builder|LocalInfo withoutTrashed()
 * @mixin Eloquent
 */
class LocalInfo extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public $table = 'localinfo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'author_id',
        'category_id',
        'store_id',
        'title',
        'content',
        'price',
        'location',
        'emd_area_id',
        'total_like',
        'total_review',
        'total_view',
        'url_share_post',
        'url_share_address',
        'accept_chat',
        'phone',
        'total_search',
        'status',
    ];

    protected $appends = [
        'address',
        'liked',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function getLocationAttribute($value): string
    {
        if (empty($value)) {
            return '';
        }

        try {
            $geometryData = geoPHP::load($value);

            if ($geometryData instanceof Geometry) {
                $point = $geometryData->asArray();
                return implode(',', $point);
            }

            return '';
        } catch (Exception $e) {
            Log::error($e);
            return '';
        }
    }

    public function getAddressAttribute(): string
    {
        $emdArea = $this->getAttribute('emdArea');

        if ($emdArea) {
            $sidoName = $emdArea->siggArea->sidoArea->name;
            $siggName = $emdArea->siggArea->name;

            return str_replace("$sidoName ", '', $emdArea->name);
        }

        return '';
    }

    public function getLikedAttribute(): bool
    {
        if (Auth::user()?->id) {
            $like = $this->likes()->where('user_id', Auth::user()?->id)->first();

            return !empty($like);
        }

        return false;
    }

    public function likes(): HasMany
    {
        return $this->hasMany(LocalInfoLike::class, 'localinfo_id');
    }

    public function commentLikes(): HasMany
    {
        return $this->hasMany(LocalInfoLike::class, 'localinfo_comment_id');
    }

    public function usersLikeLocalInfo(): \Illuminate\Support\Collection
    {
        $likes = $this->getAttribute('likes');
        $usersLiked = [];
        foreach ($likes as $like) {
            array_push($usersLiked, $like->user_id);
        }

        return User::select(['name', 'nickname', 'phone', 'avatar'])->whereIn('id', $usersLiked)->get();
    }

    public function reports(): HasMany
    {
        return $this->hasMany(LocalInfoReport::class, 'localinfo_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Mediable::class, 'target_id', 'id')->where('type', Mediable::TYPE['LOCAL_INFO']);
    }

    public function firstImage(): object|null
    {
        return $this->hasOne(Mediable::class, 'target_id', 'id')
            ->where('type', Mediable::TYPE['LOCAL_INFO']);
    }

    public function emdArea(): BelongsTo
    {
        return $this->belongsTo(EmdArea::class, 'emd_area_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class, 'localinfo_id');
    }

    public function availablePromotion(): HasOne
    {
        return $this->hasOne(Promotion::class, 'localinfo_id')
            ->where('status', PromotionStatus::IN_PROGRESS)
            ->whereRaw("accepted_at + (interval '1' day * count_day) >= now()")
            ->whereColumn('total_user', '>', 'total_promoted_user');
    }

    public function uniquePromotion(): HasOne
    {
        return $this->hasOne(Promotion::class, 'localinfo_id')
            ->whereIn('status', [PromotionStatus::WAITING_FOR_APPROVAL, PromotionStatus::IN_PROGRESS]);
    }

    public function notifications()
    {
        return $this->morphMany(NotificationObject::class, 'entity');
    }

    public function actionNotifications()
    {
        return $this->morphMany(NotificationObject::class, 'entityAction');
    }
}
