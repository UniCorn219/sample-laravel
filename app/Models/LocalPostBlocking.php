<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\LocalPostBlocking
 *
 * @property int $id
 * @property int $localpost_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|LocalPostBlocking newModelQuery()
 * @method static Builder|LocalPostBlocking newQuery()
 * @method static Builder|LocalPostBlocking query()
 * @method static Builder|LocalPostBlocking whereCreatedAt($value)
 * @method static Builder|LocalPostBlocking whereId($value)
 * @method static Builder|LocalPostBlocking whereLocalpostId($value)
 * @method static Builder|LocalPostBlocking whereUpdatedAt($value)
 * @method static Builder|LocalPostBlocking whereUserId($value)
 * @mixin Eloquent
 */
class LocalPostBlocking extends AbstractModel
{
    use HasFactory;

    public $timestamps = true;

    public $table = 'localpost_blocking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'localpost_id',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
