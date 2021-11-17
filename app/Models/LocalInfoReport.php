<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\LocalInfoReport
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $localinfo_id
 * @property int|null $localinfo_comment_id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport newQuery()
 * @method static Builder|LocalInfoReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport whereLocalinfoCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport whereLocalinfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalInfoReport whereUserId($value)
 * @method static Builder|LocalInfoReport withTrashed()
 * @method static Builder|LocalInfoReport withoutTrashed()
 * @mixin Eloquent
 */
class LocalInfoReport extends AbstractModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public $table = 'localinfo_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'localinfo_id',
        'localinfo_comment_id',
        'content',
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
