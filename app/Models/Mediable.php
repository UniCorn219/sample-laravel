<?php

namespace App\Models;

use App\Services\Aws\S3Service;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Mediable
 *
 * @method static \Illuminate\Database\Query\Builder insert(array $data)
 * @property int $id
 * @property int $target_id
 * @property int $type
 * @property int $media_id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Media|null $data
 * @method static Builder|Mediable newModelQuery()
 * @method static Builder|Mediable newQuery()
 * @method static Builder|Mediable query()
 * @method static Builder|Mediable whereCreatedAt($value)
 * @method static Builder|Mediable whereDeletedAt($value)
 * @method static Builder|Mediable whereId($value)
 * @method static Builder|Mediable whereMediaId($value)
 * @method static Builder|Mediable whereTargetId($value)
 * @method static Builder|Mediable whereType($value)
 * @method static Builder|Mediable whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Mediable extends Model
{
    use HasFactory;

    protected $table = 'mediable';

    public const TYPE = [
        'POST' => 1,
        'STORE' => 2,
        'LOCAL_POST' => 1,
        'LOCAL_INFO' => 3,
        'PRODUCT' => 4,
        'STORE_MENU' => 5,
    ];

    protected $fillable = [
        'target_id',
        'media_id',
        'type',
    ];

    protected $appends = [
        'path'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected function getPathAttribute(): ?string
    {
        $data = $this->getAttribute('data');
        if ($data) {
            $s3Service = new S3Service();

            return $s3Service->getUri($data->path);
        }

        return '';
    }

    public function data(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }
}
