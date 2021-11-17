<?php

namespace App\Models;

use App\Enum\UserActionableType;
use Eloquent;
use exception;
use Geometry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use geoPHP;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string|null $title
 * @property string|null $content
 * @property float|null $price
 * @property int|null $purchase_method
 * @property string $location
 * @property int|null $emd_area_id
 * @property int $total_like
 * @property int $total_review
 * @property int $total_view
 * @property int $total_chat_count
 * @property string|null $url_share_post
 * @property string|null $url_share_address
 * @property int|null $buyer_id
 * @property string|null $buyer_name
 * @property string|null $bought_at
 * @property int|null $status
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 * @property-read EmdArea|null $emdArea
 * @property-read string $address
 * @property-read bool $liked
 * @property-read Collection|Mediable[] $images
 * @property-read int|null $images_count
 * @property-read Collection|PostActionable[] $likes
 * @property-read int|null $likes_count
 * @property-read Collection|PostActionable[] $reports
 * @property-read int|null $reports_count
 * @property-read Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBoughtAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBuyerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEmdAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurchaseMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTotalLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTotalReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUrlShareAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUrlSharePost($value)
 * @method static Builder|Product withTrashed()
 * @method static Builder|Product withoutTrashed()
 * @mixin Eloquent
 * @property string|null $link_share
 * @property int $total_up_times
 * @property-read Collection|NotificationObject[] $actionNotifications
 * @property-read int|null $action_notifications_count
 * @property-read Collection|NotificationObject[] $notifications
 * @property-read int|null $notifications_count
 * @property-read User $owner
 * @property-read Collection|ProductPaymentMethod[] $paymentMethods
 * @property-read int|null $payment_methods_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLinkShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTotalChatCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTotalUpTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTotalView($value)
 */
class Product extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public const LIMIT_HOT_PRODUCT = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'author_id',
        'category_id',
        'title',
        'content',
        'price',
        'purchase_method',
        'location',
        'emd_area_id',
        'total_like',
        'total_review',
        'total_view',
        'url_share_post',
        'url_share_address',
        'buyer_id',
        'buyer_name',
        'bought_at',
        'status',
        'total_up_times',
        'total_chat_count',
    ];

    protected $appends = [
        'address',
        'liked',
    ];

    protected $dates = [
        'product_updated_at',
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
        } catch (exception $e) {
            return '';
        }
    }

    /**
     * @param $value
     */
    public function setLocationAttribute($value)
    {
        if (!str_contains($value, 'POINT')) {
            $location = str_replace(',', ' ', $value);
            $this->attributes['location'] = "POINT($location)";
        } else {
            $this->attributes['location'] = $value;
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
        if (isset(Auth::user()->id)) {
            $userId = Auth::user()->id;
            $like = $this->likes()->where('user_id', $userId)->first();

            return !empty($like);
        }

        return false;
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ProductLike::class);
    }

    public function usersLike()
    {
        $likes = $this->likes;

        $usersLiked = [];
        foreach ($likes as $like) {
            array_push($usersLiked, $like->user_id);
        }

        return User::select(['name', 'nickname', 'phone', 'avatar', 'id'])->whereIn('id', $usersLiked)->with(['address'])->get();
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ProductReport::class, 'product_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Mediable::class, 'target_id', 'id')->where('type', Mediable::TYPE['PRODUCT']);
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

    public function reviewed()
    {
        if (Auth::user()?->id) {
            return $this->hasOne(UserReview::class, 'product_id')->where('reviewer_id', Auth::user()?->id);
        }

        return null;
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(ProductPaymentMethod::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function transactionable(): HasOne
    {
        return $this->hasOne(ProductTransactionable::class)
            ->orderByDesc('id');
    }

    /**
     * @return HasOne
     */
    public function sortOptions(): HasOne
    {
        return $this->hasOne(ProductSortOptions::class, 'product_id', 'id');
    }
}
