<?php

namespace App\Models;

use App\Enum\UserReviewableType;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\UserReviewable
 *
 * @property int         $id
 * @property int         $user_id
 * @property int         $target_id
 * @property int         $reply_id
 * @property int         $total_like
 * @property int         $total_reply
 * @property string      $review_type post, store
 * @property string      $content
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable newQuery()
 * @method static Builder|UserReviewable onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable whereReviewType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable whereTargetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReviewable whereUserId($value)
 * @method static Builder|UserReviewable withTrashed()
 * @method static Builder|UserReviewable withoutTrashed()
 * @mixin Eloquent
 */
class UserReviewable extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $table = 'user_reviewable';

    public static int $relationType = UserReviewableType::USER;

    protected $fillable = [
        'user_id',
        'target_id',
        'reply_id',
        'total_like',
        'total_reply',
        'review_type',
        'content',
    ];

    protected $appends = [
      'liked'
    ];

    public function getTypeRelation(): string
    {
        return match(self::$relationType) {
            UserReviewableType::TRANSACTION => 'transaction',
            UserReviewableType::STORE => 'store',
            default => 'user'
        };
    }

    public function getLikedAttribute(): bool
    {
        if (Auth::user()?->id) {
            $like = $this->likes()->where('user_id', Auth::user()->id)->first();

            return !empty($like);
        }

        return false;
    }

    public function likes(): HasMany
    {
        return $this->hasMany(UserLikeReview::class, 'user_reviewable_id');
    }

    /**
     * @return HasOne
     */
    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'target_id');
    }

    /**
     * @return HasOne
     */
    public function store(): HasOne
    {
        return $this->hasOne(Store::class, 'id', 'target_id');
    }

    /**
     * @return HasOne
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'id', 'target_id');
    }

    /**
     * @return HasOne
     */
    public function targetData(): HasOne
    {
        return $this->{$this->getTypeRelation()}();
    }

    public function replies(): HasMany
    {
        return $this->hasMany(UserReviewable::class, 'reply_id', 'id')
            ->with(['targetData', 'owner.address'])
            ->orderByDesc('id');
    }
}
