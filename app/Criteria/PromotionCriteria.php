<?php

namespace App\Criteria;

use Illuminate\Database\Query\Builder;

class PromotionCriteria extends Criteria
{
    protected array $criteria = [
        'status',
        'store_id',
    ];

    public function criteriaStoreId(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $value = is_array($value) ? $value : [$value];
        $query->whereHas('localinfo', function ($query) use ($value) {
            $query->whereIn('store_id', $value);
        });
    }
}
