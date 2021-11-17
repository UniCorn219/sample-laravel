<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * \App\Models\ProductThread
 *
 * @property int $product_id
 * @property string $thread_fuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|ProductThread newModelQuery()
 * @method static Builder|ProductThread newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductThread onlyTrashed()
 * @method static Builder|ProductThread query()
 * @method static Builder|ProductThread whereCreatedAt($value)
 * @method static Builder|ProductThread whereDeletedAt($value)
 * @method static Builder|ProductThread whereProductId($value)
 * @method static Builder|ProductThread whereThreadFuid($value)
 * @method static Builder|ProductThread whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductThread withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductThread withoutTrashed()
 * @mixin Eloquent
 */
class ProductThread extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'product_threads';

    protected $fillable = [
        'product_id',
        'thread_fuid',
        'deleted_at',
    ];
}
