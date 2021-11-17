<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\OffensiveWord
 *
 * @property int $id
 * @property string $word
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OffensiveWord newModelQuery()
 * @method static Builder|OffensiveWord newQuery()
 * @method static Builder|OffensiveWord query()
 * @method static Builder|OffensiveWord whereCreatedAt($value)
 * @method static Builder|OffensiveWord whereId($value)
 * @method static Builder|OffensiveWord whereUpdatedAt($value)
 * @method static Builder|OffensiveWord whereWord($value)
 * @mixin Eloquent
 */
class OffensiveWord extends AbstractModel
{
    protected $table = 'offensive_words';

    protected $fillable = [
        'word',
        'language_code',
    ];
}
