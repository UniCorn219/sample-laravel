<?php

namespace App\Criteria;

use App\Enum\ProductPurchaseMethod;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ProductCriteria extends Criteria
{
    protected array $criteria = [
        'keyword',
        'category_id',
        'purchase_method',
        'emd_area_id',
        'store_id',
        'status',
        'author_id',
        'buyer_id',
        'hide_author_id',
        'location',
        'distance',
    ];

    protected function criteriaKeyword(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->where(function (\Illuminate\Database\Eloquent\Builder|Builder $query) use ($value) {
            $query->where('title', 'like', "%$value%")
                ->orWhere('content', 'like', "%$value%")
                ->orWhere('title', 'like', "%".strtolower($value)."%")
                ->orWhere('content', 'like', "%".strtolower($value)."%");
        });
    }

    protected function criteriaPurchaseMethod(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        if (in_array((int)$value, [ProductPurchaseMethod::ONLINE, ProductPurchaseMethod::OFFLINE])) {
            $query->whereIn('purchase_method', [$value, ProductPurchaseMethod::BOTH]);
        }
    }

    protected function criteriaBuyerId(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->where('buyer_id', $value);
    }

    protected function criteriaLocation(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->addSelect(DB::raw('ST_Distance(location, ref_geom) AS distance'))
            ->crossJoinSub("SELECT ST_MakePoint($value)::geography AS ref_geom", 'temporary');
    }

    protected function criteriaDistance(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $params = $this->getParam();
        if (isset($params['location']) && is_numeric($value)) {
            $query->whereRaw("ST_DWithin(location, ref_geom, $value)");
        }
    }

    protected function criteriaStatus(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        if (is_array($value)) {
            $query->whereIn('status', $value);
        } else {
            $query->where('status', $value);
        }
    }

    protected function criteriaAuthorId(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->where('author_id', $value);
    }

    protected function criteriaHideAuthorId(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->whereNotIn('author_id', $value);
    }
}
