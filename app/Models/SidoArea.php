<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\SidoArea
 *
 * @property int $id
 * @property int $adm_code
 * @property string $name
 * @property string|null $version
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SidoArea newModelQuery()
 * @method static Builder|SidoArea newQuery()
 * @method static Builder|SidoArea query()
 * @method static Builder|SidoArea whereAdmCode($value)
 * @method static Builder|SidoArea whereCreatedAt($value)
 * @method static Builder|SidoArea whereDeletedAt($value)
 * @method static Builder|SidoArea whereId($value)
 * @method static Builder|SidoArea whereName($value)
 * @method static Builder|SidoArea whereUpdatedAt($value)
 * @method static Builder|SidoArea whereVersion($value)
 * @mixin Eloquent
 */
class SidoArea extends AbstractModel
{
    protected $table = 'sido_areas';
}
