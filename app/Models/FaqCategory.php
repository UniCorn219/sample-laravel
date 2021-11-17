<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\FaqCategory
 *
 * @property int $id
 * @property string|null $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $total_views
 * @method static Builder|FaqCategory newModelQuery()
 * @method static Builder|FaqCategory newQuery()
 * @method static Builder|FaqCategory query()
 * @method static Builder|FaqCategory whereContent($value)
 * @method static Builder|FaqCategory whereCreatedAt($value)
 * @method static Builder|FaqCategory whereId($value)
 * @method static Builder|FaqCategory whereTotalViews($value)
 * @method static Builder|FaqCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class FaqCategory extends AbstractModel
{
    protected $table = 'faq_categories';

    protected $fillable = [
        'content',
        'total_views',
    ];
}
