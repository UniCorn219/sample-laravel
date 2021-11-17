<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * \App\Models\MenuStore
 *
 * @property int $id
 * @property int $store_id
 * @property string $title
 * @property float $price
 * @property string|null $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $is_main
 * @method static Builder|MenuStore newModelQuery()
 * @method static Builder|MenuStore newQuery()
 * @method static Builder|MenuStore query()
 * @method static Builder|MenuStore whereCreatedAt($value)
 * @method static Builder|MenuStore whereId($value)
 * @method static Builder|MenuStore whereIsMain($value)
 * @method static Builder|MenuStore whereOrder($value)
 * @method static Builder|MenuStore wherePrice($value)
 * @method static Builder|MenuStore whereStoreId($value)
 * @method static Builder|MenuStore whereTitle($value)
 * @method static Builder|MenuStore whereUpdatedAt($value)
 * @mixin Eloquent
 */
class MenuStore extends AbstractModel
{
    protected $table = 'menu_store';

    protected $fillable = [
        'store_id',
        'title',
        'price',
        'order',
        'is_main',
    ];

    public function image(): HasOne
    {
        return $this->hasOne(Mediable::class, 'target_id', 'id')
            ->where('type', Mediable::TYPE['STORE_MENU'])
            ->orderByDesc('id');
    }
}
