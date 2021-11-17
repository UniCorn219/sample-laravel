<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\EmdArea
 *
 * @property int $id
 * @property int $sigg_area_id
 * @property int $code
 * @property string $name
 * @property string $wards_name
 * @property string|null $description
 * @property string|null $version
 * @property mixed|null $polygon
 * @property mixed|null $location
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read SiggArea $siggArea
 * @method static Builder|EmdArea newModelQuery()
 * @method static Builder|EmdArea newQuery()
 * @method static Builder|EmdArea query()
 * @method static Builder|EmdArea whereCode($value)
 * @method static Builder|EmdArea whereCreatedAt($value)
 * @method static Builder|EmdArea whereDeletedAt($value)
 * @method static Builder|EmdArea whereDescription($value)
 * @method static Builder|EmdArea whereId($value)
 * @method static Builder|EmdArea whereLocation($value)
 * @method static Builder|EmdArea whereName($value)
 * @method static Builder|EmdArea wherePolygon($value)
 * @method static Builder|EmdArea whereSiggAreaId($value)
 * @method static Builder|EmdArea whereUpdatedAt($value)
 * @method static Builder|EmdArea whereVersion($value)
 * @method static Builder|EmdArea whereWardsName($value)
 * @mixin Eloquent
 */
class EmdArea extends AbstractModel
{
    protected $table = 'emd_areas';

    /**
     * @return BelongsTo
     */
    public function siggArea(): BelongsTo
    {
        return $this->belongsTo(SiggArea::class);
    }
}
