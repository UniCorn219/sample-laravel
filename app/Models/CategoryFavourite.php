<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\CategoryFavourite
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CategoryFavourite newModelQuery()
 * @method static Builder|CategoryFavourite newQuery()
 * @method static Builder|CategoryFavourite query()
 * @method static Builder|CategoryFavourite whereCategoryId($value)
 * @method static Builder|CategoryFavourite whereCreatedAt($value)
 * @method static Builder|CategoryFavourite whereId($value)
 * @method static Builder|CategoryFavourite whereUpdatedAt($value)
 * @method static Builder|CategoryFavourite whereUserId($value)
 * @mixin Eloquent
 */
class CategoryFavourite extends AbstractModel
{
    protected $table = 'category_favourite';

    protected $fillable = [
        'user_id',
        'category_id',
    ];
}
