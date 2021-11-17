<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\LocalInfoComment
 *
 * @property int $id
 * @property int $user_id
 * @property int $localinfo_id
 * @property int|null $reply_id
 * @property int $total_like
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|LocalInfoLike[] $likes
 * @property-read int|null $likes_count
 * @property-read Collection|LocalInfoComment[] $replies
 * @property-read int|null $replies_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment newQuery()
 * @method static Builder|LocalInfoComment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment whereLocalinfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment whereReplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment whereTotalLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoComment whereUserId($value)
 * @method static Builder|LocalInfoComment withTrashed()
 * @method static Builder|LocalInfoComment withoutTrashed()
 * @mixin Eloquent
 */
class LocalInfoComment extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public $table = 'localinfo_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'localinfo_id',
        'total_like',
        'reply_id',
        'content',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(LocalInfoComment::class, 'reply_id', 'id')
            ->with('user.address')
            ->orderByDesc('id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(LocalInfoLike::class, 'localinfo_comment_id');
    }

    public function liked()
    {
        if (Auth::user()?->id) {
            return $this->hasOne(LocalInfoLike::class, 'localinfo_comment_id')
                ->where('user_id', Auth::user()?->id);
        }

        return null;
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
