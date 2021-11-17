<?php

namespace App\Models;

use App\Services\Aws\S3Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(int $mission_id)
 */
class Mission extends AbstractModel
{
    use HasFactory;
    use SoftDeletes;

    const MISSION_1_ID = 1;
    const MISSION_2_ID = 2;
    const MISSION_3_ID = 3;
    const MISSION_4_ID = 4;
    const MISSION_5_ID = 5;
    const MISSION_6_ID = 6;
    const MISSION_7_ID = 7;
    const MISSION_8_ID = 8;
    const MISSION_9_ID = 9;
    const MISSION_10_ID = 10;
    const MISSION_11_ID = 11;
    const MISSION_12_ID = 12;

    protected $table = 'missions';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'title',
        'point',
        'icon_url',
        'active_icon_url',
        'desc_icon_url',
        'desc_active_icon_url',
        'description',
        'battery_point',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * @param $value
     *
     * @return string
     */
    public function getIconUrlAttribute($value): string
    {
        if ($value) {
            $s3service = new S3Service();
            return $s3service->getUri($value);
        }

        return '';
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getActiveIconUrlAttribute($value): string
    {
        if ($value) {
            $s3service = new S3Service();
            return $s3service->getUri($value);
        }

        return '';
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getDescIconUrlAttribute($value): string
    {
        if ($value) {
            $s3service = new S3Service();
            return $s3service->getUri($value);
        }

        return '';
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getDescActiveIconUrlAttribute($value): string
    {
        if ($value) {
            $s3service = new S3Service();
            return $s3service->getUri($value);
        }

        return '';
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getBatteryPointAttribute($value): string
    {
        return '+' . $value;
    }
}
