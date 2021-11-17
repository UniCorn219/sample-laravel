<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\SiggArea
 *
 * @property int $id
 * @property int $sido_area_id
 * @property int $adm_code
 * @property string $name
 * @property string|null $version
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read SidoArea $sidoArea
 * @method static Builder|SiggArea newModelQuery()
 * @method static Builder|SiggArea newQuery()
 * @method static Builder|SiggArea query()
 * @method static Builder|SiggArea whereAdmCode($value)
 * @method static Builder|SiggArea whereCreatedAt($value)
 * @method static Builder|SiggArea whereDeletedAt($value)
 * @method static Builder|SiggArea whereId($value)
 * @method static Builder|SiggArea whereName($value)
 * @method static Builder|SiggArea whereSidoAreaId($value)
 * @method static Builder|SiggArea whereUpdatedAt($value)
 * @method static Builder|SiggArea whereVersion($value)
 * @mixin Eloquent
 */
class SiggArea extends AbstractModel
{
    protected $table = 'sigg_areas';

    /**
     * @return BelongsTo
     */
    public function sidoArea(): BelongsTo
    {
        return $this->belongsTo(SidoArea::class);
    }
}
