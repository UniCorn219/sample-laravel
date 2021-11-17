<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Media
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $type image|video|anything
 * @property string $extension png|jpeg|mp4|any type
 * @property string|null $thumbnail_path
 * @property int|null $size
 * @property int|null $height
 * @property int|null $width
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Media newModelQuery()
 * @method static Builder|Media newQuery()
 * @method static Builder|Media query()
 * @method static Builder|Media whereCreatedAt($value)
 * @method static Builder|Media whereDeletedAt($value)
 * @method static Builder|Media whereExtension($value)
 * @method static Builder|Media whereHeight($value)
 * @method static Builder|Media whereId($value)
 * @method static Builder|Media whereName($value)
 * @method static Builder|Media wherePath($value)
 * @method static Builder|Media whereSize($value)
 * @method static Builder|Media whereThumbnailPath($value)
 * @method static Builder|Media whereType($value)
 * @method static Builder|Media whereUpdatedAt($value)
 * @method static Builder|Media whereWidth($value)
 * @mixin Eloquent
 */
class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'path',
        'type',
        'file_type',
        'thumbnail_path',
        'size',
        'height',
        'width',
    ];
}
