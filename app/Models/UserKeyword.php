<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\UserAddress
 *
 * @property int $id
 * @property int $user_id
 * @property int $area_id
 * @property int $province_id
 * @property int $district_id
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
class UserKeyword extends AbstractModel
{
    use HasFactory;

    const MAX_KEYWORD = 10;

    protected $table = 'user_keyword';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'keyword',
    ];
}
