<?php

namespace App\Models;

use App\Services\Aws\S3Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ko
 * @property string|null $name_vn
 * @property string|null $description
 * @property int $type 1: product, 2: local post, 3: local info
 * @property int|null $parent_id
 * @property int|null $order
 * @property string|null $icon_url
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIconUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameKo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameVn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 * @mixin \Eloquent
 */
class Category extends AbstractModel
{
    use HasFactory, SoftDeletes;

    const TYPE_PRODUCT    = 1;
    const TYPE_LOCAL_POST = 2;
    const TYPE_LOCAL_INFO = 3;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_en',
        'name_ko',
        'name_vn',
        'description',
        'icon_url',
        'type',
        'parent_id',
        'order'
    ];

    protected $appends = ['name'];

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->name_ko;
    }

    public function getIconUrlAttribute($value)
    {
        if ($value) {
            $s3service = new S3Service();
            return $s3service->getUri($value);
        }

        return '';
    }
}
