<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * \App\Models\BankName
 *
 * @property int $id
 * @property string $name
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
class BankName extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'bank_names';
}
