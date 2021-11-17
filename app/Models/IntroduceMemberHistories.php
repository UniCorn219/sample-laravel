<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\IntroduceMemberHistories
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|IntroduceMemberHistories newModelQuery()
 * @method static Builder|IntroduceMemberHistories newQuery()
 * @method static Builder|IntroduceMemberHistories query()
 * @method static Builder|IntroduceMemberHistories whereCategoryId($value)
 * @method static Builder|IntroduceMemberHistories whereCreatedAt($value)
 * @method static Builder|IntroduceMemberHistories whereId($value)
 * @method static Builder|IntroduceMemberHistories whereUpdatedAt($value)
 * @method static Builder|IntroduceMemberHistories whereUserId($value)
 * @mixin Eloquent
 */
class IntroduceMemberHistories extends AbstractModel
{
    protected $table = 'introduce_member_histories';

    protected $fillable = [
        'presenter_id',
        'user_id',
        'phone',
        'point'
    ];
}
