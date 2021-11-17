<?php

namespace App\Criteria;

use Illuminate\Database\Query\Builder;

class LocalInfoCriteria extends Criteria
{
    protected array $criteria = [
        'keyword',
        'category_id',
        'emd_area_id',
        'store_id',
        'radius_long_lat',
    ];

    protected function criteriaKeyword(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->where(function (\Illuminate\Database\Eloquent\Builder|Builder $query) use ($value) {
            $query->where('title', 'like', "%$value%")
                ->orWhere('content', 'like', "%$value%")
                ->orWhere('title', 'like', "%" . strtolower($value) . "%")
                ->orWhere('content', 'like', "%" . strtolower($value) . "%");
        });
    }

    protected function criteriaRadiusLongLat(\Illuminate\Database\Eloquent\Builder|Builder $query, $values)
    {
        if (!isset($values['long']) || !isset($values['lat']) || !isset($values['radius'])) {
            return;
        }

        $query->whereHas('store', function ($query) use ($values) {
            $query->whereRaw(
                'ST_DWithin(ST_MakePoint(?,?)::geography, stores.location::geography,?)',
                [$values['long'], $values['lat'], $values['radius']]
            );
        });
    }

    protected function criteriaCategoryId(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        if (is_array($value)) {
            $categoryIds = $value;
        } elseif (is_numeric($value)) {
            $categoryIds = [$value];
        } else {
            return;
        }

        $query->whereIn('localinfo.category_id', $categoryIds);
    }
}
