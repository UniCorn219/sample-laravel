<?php

namespace App\Models;

use Eloquent;
use Exception;
use Geometry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use geoPHP;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\LocalPost
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string|null $content
 * @property string $location
 * @property int|null $emd_area_id
 * @property int $total_like
 * @property int $total_click
 * @property int $total_review
 * @property int $total_view
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|LocalPostLike[] $commentLikes
 * @property-read int|null $comment_likes_count
 * @property-read EmdArea|null $emdArea
 * @property-read string $address
 * @property-read MorphOne|null $liked
 * @property-read \Illuminate\Database\Eloquent\Collection|Mediable[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|LocalPostLike[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|LocalPostReport[] $reports
 * @property-read int|null $reports_count
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost newQuery()
 * @method static Builder|LocalPost onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereEmdAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereTotalLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereTotalReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPost whereUpdatedAt($value)
 * @method static Builder|LocalPost withTrashed()
 * @method static Builder|LocalPost withoutTrashed()
 * @mixin Eloquent
 */
class LocalPost extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public $table = 'localpost';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'author_id',
        'category_id',
        'content',
        'location',
        'emd_area_id',
        'total_like',
        'total_review',
        'total_view',
        'total_click',
        'address_place_name',
        'status',
        'address_detail',
        'is_share_location',
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
            Log::info($e);
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
        return $this->hasMany(LocalPostLike::class, 'localpost_id');
    }

    public function commentLikes(): HasMany
    {
        return $this->hasMany(LocalPostLike::class, 'localpost_comment_id');
    }

    public function usersLikeLocalPost(): Collection
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
        return $this->hasMany(LocalPostReport::class, 'localpost_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Mediable::class, 'target_id', 'id')->where('type', Mediable::TYPE['LOCAL_POST']);
    }

    public function emdArea(): BelongsTo
    {
        return $this->belongsTo(EmdArea::class, 'emd_area_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
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
