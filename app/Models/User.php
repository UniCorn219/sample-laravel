<?php

namespace App\Models;

use App\Helpers\Common;
use App\Services\Aws\S3Service;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * \App\Models\User
 *
 * @property int $id
 * @property string $uniqid
 * @property string $id_flex
 * @property bool $is_admin
 * @property int $role_admin
 * @property string $name
 * @property string $phone
 * @property string $password
 * @property string|null $avatar
 * @property int|null $introduced_by
 * @property int|null $number_referral
 * @property int $battery_point
 * @property int $battery_level
 * @property int $level
 * @property int $total_point
 * @property bool $has_left
 * @property string|null $reason_has_left
 * @property string $referral_link
 * @property string $firebase_uid
 * @property string|null $deleted_at
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $birth
 * @property string|null $gender
 * @property string|null $point_reason
 * @property string|null $wm
 * @property string|null $refer
 * @property string|null $refer_user
 * @property string $code
 * @property int $cnt_refer
 * @property int $cnt_open
 * @property int $is_allow
 * @property int $allow_push
 * @property int $is_block
 * @property string|null $allow_dt
 * @property \datetime|null $insert_dt
 * @property \datetime|null $update_dt
 * @property string|null $quited_at
 * @property string|null $user_agent
 * @property string|null $token_fcm
 * @property string|null $nickname
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAddress[] $address
 * @property-read int|null $address_count
 * @property-read string $avatar_url
 * @property-read UserSetting|null $setting
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereBatteryLevel($value)
 * @method static Builder|User whereBatteryPoint($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereHasLeft($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIdFlex($value)
 * @method static Builder|User whereIntroducedBy($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereLevel($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereNumberReferral($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereReasonHasLeft($value)
 * @method static Builder|User whereReferralLink($value)
 * @method static Builder|User whereRoleAdmin($value)
 * @method static Builder|User whereTotalPoint($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUuid($value)
 * @method static firstOrNew(array $dataInsertUser)
 * @method static findOrFail(mixed $input)
 * @method static create(array $dataInsertUser)
 * @method static whereIn(string $string, mixed $input)
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static Builder|User whereAllowDt($value)
 * @method static Builder|User whereAllowPush($value)
 * @method static Builder|User whereBirth($value)
 * @method static Builder|User whereCntOpen($value)
 * @method static Builder|User whereCntRefer($value)
 * @method static Builder|User whereCode($value)
 * @method static Builder|User whereFirebaseUid($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereInsertDt($value)
 * @method static Builder|User whereIsAllow($value)
 * @method static Builder|User whereIsBlock($value)
 * @method static Builder|User whereNickName($value)
 * @method static Builder|User wherePointReason($value)
 * @method static Builder|User whereQuitedAt($value)
 * @method static Builder|User whereRefer($value)
 * @method static Builder|User whereReferUser($value)
 * @method static Builder|User whereTokenFcm($value)
 * @method static Builder|User whereUpdateDt($value)
 * @method static Builder|User whereUserAgent($value)
 * @method static Builder|User whereWm($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @property-read Collection|UserMission[] $missions
 * @property-read int|null $missions_count
 * @mixin Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    public const CREATED_AT = 'insert_dt';

    public const FOLDER_AVATAR = 'user_avatar';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'uniqid',
        'id_flex',
        'is_admin',
        'role_admin',
        'name',
        'nickname',
        'phone',
        'avatar',
        'introduced_by',
        'number_referral',
        'battery_point',
        'battery_level',
        'level',
        'total_point',
        'has_left',
        'reason_has_left',
        'referral_link',
        'birth',
        'gender',
        'point_reason',
        'wm',
        'refer',
        'refer_user',
        'code',
        'cnt_refer',
        'cnt_open',
        'is_allow',
        'allow_push',
        'is_block',
        'allow_dt',
        'insert_dt',
        'update_dt',
        'quited_at',
        'user_agent',
        'firebase_uid',
        'token_fcm',
        'number_of_time_block_chatting',
        'block_chatting_expired',
        'reason_quit',
        'link_share'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pwd',
    ];

    protected $appends = [
        'avatar_url',
        'is_block_chatting',
        'refer_link'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'insert_dt'  => 'datetime:Y-m-d H:i:s',
        'update_dt'  => 'datetime:Y-m-d H:i:s',
        'deleted_dt' => 'datetime:Y-m-d H:i:s',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    protected $table = 'users';

    public function getAvatarUrlAttribute(): string
    {
        $avatar = $this->getAttribute('avatar');

        if ($avatar) {
            $s3service = new S3Service();
            return $s3service->getUri($avatar);
        }

        return '';
    }

    /**
     * Get user is block chatting for user/store or not
     *
     * @return bool
     */
    public function getIsBlockChattingAttribute(): bool
    {
        return $this->getAttribute('block_chatting_expired') !== null;
    }

    public function getReferLinkAttribute(): string
    {
        $code = $this->getAttribute('code');

        return config('app.api_gateway_api') . "/o2o/api/refer/$code";
    }

    public static function formatDataInsert($data): array
    {
        return [
            'id'              => isset($data['id']) ? (int)$data['id'] : '',
            'uniqid'          => isset($data['uniqid']) ? $data['uniqid'] : '',
            'id_flex'         => isset($data['id_flex']) ? $data['id_flex'] : '',
            'is_admin'        => isset($data['is_admin']) ? (boolean)$data['is_admin'] : false,
            'role_admin'      => isset($data['role_admin']) ? (int)$data['role_admin'] : 3,
            'name'            => isset($data['name']) ? $data['name'] : '',
            'nickname'        => null,
            'phone'           => isset($data['phone']) ? $data['phone'] : '',
            'avatar'          => isset($data['avatar']) ? $data['avatar'] : '',
            'introduced_by'   => isset($data['introduced_by']) ? (int)$data['introduced_by'] : null,
            'number_referral' => isset($data['number_referral']) ? (int)$data['number_referral'] : 0,
            'battery_point'   => isset($data['battery_point']) ? (int)$data['battery_point'] : 600,
            'battery_level'   => isset($data['battery_level']) ? (int)$data['battery_level'] : 3,
            'total_point'     => isset($data['total_point']) ? (int)$data['total_point'] : 0,
            'has_left'        => isset($data['has_left']) ? (boolean)$data['has_left'] : false,
            'reason_has_left' => isset($data['reason_has_left']) ? $data['reason_has_left'] : '',
            'referral_link'   => isset($data['referral_link']) ? $data['referral_link'] : '',
            'birth'           => isset($data['birth']) ? $data['birth'] : null,
            'gender'          => isset($data['gender']) ? $data['gender'] : null,
            'point_reason'    => isset($data['point_reason']) ? $data['point_reason'] : '',
            'wm'              => isset($data['wm']) ? $data['wm'] : '',
            'refer'           => isset($data['refer']) ? $data['refer'] : '',
            'refer_user'      => isset($data['refer_user']) ? $data['refer_user'] : '',
            'code'            => isset($data['code']) ? $data['code'] : '',
            'cnt_refer'       => isset($data['cnt_refer']) ? (int)$data['cnt_refer'] : 0,
            'cnt_open'        => isset($data['cnt_open']) ? (int)$data['cnt_open'] : 0,
            'is_allow'        => isset($data['is_allow']) ? (int)$data['is_allow'] : 1,
            'allow_push'      => isset($data['allow_push']) ? (int)$data['allow_push'] : 1,
            'is_block'        => isset($data['is_block']) ? (int)$data['is_block'] : 0,
            'allow_dt'        => isset($data['allow_dt']) ? $data['allow_dt'] : null,
            'insert_dt'       => isset($data['insert_dt']) ? Common::convertTimeKoreaToUtc($data['insert_dt']) : null,
            'update_dt'       => isset($data['update_dt']) ? Common::convertTimeKoreaToUtc($data['update_dt']) : null,
            'quited_at'       => isset($data['quited_at']) ? Common::convertTimeKoreaToUtc($data['quited_at']) : null,
            'user_agent'      => isset($data['user_agent']) ? $data['user_agent'] : '',
            'firebase_uid'    => isset($data['firebase_uid']) ? $data['firebase_uid'] : null,
            'token_fcm'       => isset($data['token_fcm']) ? $data['token_fcm'] : null,
            'region_id'       => isset($data['region_id']) ? $data['region_id'] : null,
            'region_name'     => isset($data['region_name']) ? $data['region_name'] : null,
            'branch_id'       => isset($data['branch_id']) ? $data['branch_id'] : null,
            'branch_name'     => isset($data['branch_name']) ? $data['branch_name'] : null,
            'last_visited_at' => isset($data['last_visited_at']) ? Common::convertTimeKoreaToUtc($data['last_visited_at']) : null,
            'reason_quit'     => isset($data['reason_quit']) ? $data['reason_quit'] : null,
        ];
    }

    public static function formatDataUpdate($param): array
    {
        $data = [];

        if (isset($param['is_admin'])) {
            $data['is_admin'] = $param['is_admin'];
        }
        if (isset($param['role_admin'])) {
            $data['role_admin'] = (int)$param['role_admin'];
        }
        if (isset($param['name'])) {
            $data['name'] = $param['name'];
        }
        if (isset($param['phone'])) {
            $data['phone'] = $param['phone'];
        }
        if (isset($param['avatar'])) {
            $data['avatar'] = $param['avatar'];
        }
        if (isset($param['introduced_by'])) {
            $data['introduced_by'] = (int)$param['introduced_by'];
        }
        if (isset($param['number_referral'])) {
            $data['number_referral'] = (int)$param['number_referral'];
        }
        if (isset($param['battery_point'])) {
            $data['battery_point'] = (int)$param['battery_point'];
        }
        if (isset($param['total_point'])) {
            $data['total_point'] = (int)$param['total_point'];
        }
        if (isset($param['has_left'])) {
            $data['has_left'] = (boolean)$param['has_left'];
        }
        if (isset($param['reason_has_left'])) {
            $data['reason_has_left'] = $param['reason_has_left'];
        }
        if (isset($param['referral_link'])) {
            $data['referral_link'] = $param['referral_link'];
        }
        if (isset($param['birth'])) {
            $data['birth'] = $param['birth'];
        }
        if (isset($param['gender'])) {
            $data['gender'] = $param['gender'];
        }
        if (isset($param['point_reason'])) {
            $data['point_reason'] = $param['point_reason'];
        }
        if (isset($param['wm'])) {
            $data['wm'] = $param['wm'];
        }
        if (isset($param['refer'])) {
            $data['refer'] = $param['refer'];
        }
        if (isset($param['refer_user'])) {
            $data['refer_user'] = $param['refer_user'];
        }
        if (isset($param['code'])) {
            $data['code'] = $param['code'];
        }
        if (isset($param['cnt_refer'])) {
            $data['cnt_refer'] = (int)$param['cnt_refer'];
        }
        if (isset($param['cnt_open'])) {
            $data['cnt_open'] = (int)$param['cnt_open'];
        }
        if (isset($param['is_allow'])) {
            $data['is_allow'] = (int)$param['is_allow'];
        }
        if (isset($param['allow_push'])) {
            $data['allow_push'] = (int)$param['allow_push'];
        }
        if (isset($param['is_block'])) {
            $data['is_block'] = (int)$param['is_block'];
        }
        if (isset($param['allow_dt'])) {
            $data['allow_dt'] = $param['allow_dt'];
            $data['allow_dt'] = Common::convertTimeKoreaToUtc($data['allow_dt']);
        }
        if (isset($param['insert_dt'])) {
            $data['insert_dt'] = $param['insert_dt'];
            $data['insert_dt'] = Common::convertTimeKoreaToUtc($data['insert_dt']);
        }
        if (isset($param['update_dt'])) {
            $data['update_dt'] = $param['update_dt'];
            $data['update_dt'] = Common::convertTimeKoreaToUtc($data['update_dt']);
        }
        if (isset($param['quited_at'])) {
            $data['quited_at'] = $param['quited_at'];
            $data['quited_at'] = Common::convertTimeKoreaToUtc($data['quited_at']);
        }
        if (isset($param['user_agent'])) {
            $data['user_agent'] = $param['user_agent'];
        }
        if (isset($param['token_fcm'])) {
            $data['token_fcm'] = $param['token_fcm'];
        }
        if (isset($param['region_id'])) {
            $data['region_id'] = $param['region_id'];
        }
        if (isset($param['region_name'])) {
            $data['region_name'] = $param['region_name'];
        }
        if (isset($param['branch_id'])) {
            $data['branch_id'] = $param['branch_id'];
        }
        if (isset($param['branch_name'])) {
            $data['branch_name'] = $param['branch_name'];
        }
        if (isset($param['last_visited_at'])) {
            $data['last_visited_at'] = $param['last_visited_at'];
            $data['last_visited_at'] = Common::convertTimeKoreaToUtc($data['last_visited_at']);
        }
        if (isset($param['reason_quit'])) {
            $data['reason_quit'] = $param['reason_quit'];
        }

        return $data;
    }

    /**
     * hasMay user address
     *
     * @return HasMany
     */
    public function address(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * @return HasOne
     */
    public function setting(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    /**
     * @return HasMany
     */
    public function missions(): HasMany
    {
        return $this->hasMany(UserMission::class);
    }

    /**
     * @return HasMany
     */
    public function referUser(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'refer_user');
    }

    /**
     * @return MorphMany
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(NotificationObject::class, 'entity');
    }
}
