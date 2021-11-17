<?php

namespace App\Models;

use App\Enum\UserActionableType;
use App\Services\Aws\S3Service;
use Eloquent;
use exception;
use Geometry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use geoPHP;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Store
 *
 * @property int                         $id
 * @property int                         $owner_id
 * @property string                      $name
 * @property string|null                 $phone
 * @property string                      $location
 * @property int|null                    $emd_area_id
 * @property string|null                 $link_share_address
 * @property Carbon|null                 $deleted_at
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $last_visited_at
 * @property Carbon|null                 $updated_at
 * @property string|null                 $business_type
 * @property string|null                 $status
 * @property Collection|Store[]          $address
 * @property string|null                 $introduce
 * @property string|null                 $day_off
 * @property int|null                    $category_id
 * @property string|null                 $image_id
 * @property string|null                 $open_time
 * @property string|null                 $close_time
 * @property int                         $total_like
 * @property int                         $total_follow
 * @property int                         $total_view
 * @property int                         $total_post
 * @property string|null                 $avatar
 * @property string|null                 $quick_announcement
 * @property int                         $total_review
 * @property string|null                 $zip
 * @property string|null                 $address_detail
 * @property bool                        $is_share_location
 * @property bool                        $updated_address_detail
 * @property string                      $firebase_uid
 * @property-read int|null               $address_count
 * @property-read Category|null          $category
 * @property-read string                 $avatar_url
 * @property-read bool                   $followed
 * @property-read Collection|Mediable[]  $images
 * @property-read int|null               $images_count
 * @property-read Collection|MenuStore[] $menus
 * @property-read int|null               $menus_count
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static Builder|Store onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAddressDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCloseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDayOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereEmdAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereIntroduce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereIsShareLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLinkShareAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereOpenTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereQuickAnnouncement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTotalFollow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTotalLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTotalReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAddressDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereZip($value)
 * @method static Builder|Store withTrashed()
 * @method static Builder|Store withoutTrashed()
 * @mixin Eloquent
 */
class Store extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public const FOLDER_AVATAR = 'store_avatar';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'owner_id',
        'category_id',
        'image_id',
        'name',
        'avatar',
        'business_type',
        'phone',
        'total_like',
        'total_review',
        'total_follow',
        'total_view',
        'total_post',
        'location',
        'is_share_location',
        'zip',
        'address',
        'address_detail',
        'updated_address_detail',
        'status',
        'introduce',
        'open_time',
        'close_time',
        'emd_area_id',
        'link_share_address',
        'day_off',
        'quick_announcement',
        'firebase_uid',
        'last_visited_at',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'avatar_url',
        'followed'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $dates = [
        'last_visited_at'
    ];

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

    public function getAvatarUrlAttribute(): string
    {
        $avatar = $this->getAttribute('avatar');

        if ($avatar) {
            $s3service = new S3Service();
            return $s3service->getUri($avatar);
        }

        return '';
    }

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
        } catch (exception) {
            return '';
        }
    }


    public function getFollowedAttribute(): bool
    {
        if (Auth::user()?->id) {
            $followed = UserActionable::where([
                'user_id' => Auth::user()->id,
                'target_id' => $this->id,
                'target_type' => UserActionableType::ENTITY_STORE,
                'action_type' => UserActionableType::ACTION_USER_FOLLOW,
            ])->first();

            return !empty($followed);
        }

        return false;
    }


    public function menus(): HasMany
    {
        return $this->hasMany(MenuStore::class, 'store_id')
            ->orderBy('order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Mediable::class, 'target_id')->where('type', Mediable::TYPE['STORE']);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function addressMap(): HasOne
    {
        return $this->hasOne(StoreAddress::class);
    }

    /**
     * @return MorphMany
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(NotificationObject::class, 'entity');
    }
}
