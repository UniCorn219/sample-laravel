<?php

namespace App\Models;

use Eloquent;
use Exception;
use Geometry;
use geoPHP;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\StoreAddress
 *
 * @property int $id
 * @property int $user_id
 * @property int $emd_area_id
 * @property mixed $location
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserAddress newModelQuery()
 * @method static Builder|UserAddress newQuery()
 * @method static Builder|UserAddress query()
 * @method static Builder|UserAddress whereAreaId($value)
 * @method static Builder|UserAddress whereCreatedAt($value)
 * @method static Builder|UserAddress whereDeletedAt($value)
 * @method static Builder|UserAddress whereDistrictId($value)
 * @method static Builder|UserAddress whereId($value)
 * @method static Builder|UserAddress whereLocation($value)
 * @method static Builder|UserAddress whereProvinceId($value)
 * @method static Builder|UserAddress whereUpdatedAt($value)
 * @method static Builder|UserAddress whereUserId($value)
 * @mixin Eloquent
 */
class StoreAddress extends AbstractModel
{
    protected $table = 'store_address';

    protected $fillable = [
        'store_id',
        'emd_area_id',
        'location',
        'emd_name',
    ];

    protected $appends = [
        'emd'
    ];

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
        } catch (Exception $e) {
            return '';
        }
    }

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

    public function emdArea(): BelongsTo
    {
        return $this->belongsTo(EmdArea::class, 'emd_area_id');
    }

    public function getEmdNameAttribute(): string
    {
        $emdArea = $this->emdArea()->with('siggArea.sidoArea')->first();

        if ($emdArea) {
            $sidoName = $emdArea->siggArea->sidoArea->name;
            $siggName = $emdArea->siggArea->name;

            return str_replace("$sidoName ", '', $emdArea->name);
        }

        return '';
    }

    public function getEmdAttribute(): string
    {
        $emdArea = $this->emdArea()->with('siggArea.sidoArea')->first();

        if ($emdArea) {
            $sidoName = $emdArea->siggArea->sidoArea->name;
            $siggName = $emdArea->siggArea->name;

            return str_replace("$sidoName $siggName ", '', $emdArea->name);
        }

        return '';
    }
}
