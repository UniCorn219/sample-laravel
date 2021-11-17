<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\FaqQuestion
 *
 * @property int $id
 * @property int $faq_category_id
 * @property string|null $question
 * @property int $total_views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FaqAnswer[] $answers
 * @property-read int|null $answers_count
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion whereFaqCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion whereTotalViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FaqQuestion extends AbstractModel
{
    protected $table = 'faq_questions';

    protected $fillable = [
        'faq_category_id',
        'question',
        'total_views'
    ];

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(FaqAnswer::class, 'faq_category_question_id', 'id');
    }
}
