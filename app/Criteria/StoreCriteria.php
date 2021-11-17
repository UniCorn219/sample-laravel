<?php

namespace App\Criteria;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\DB;

class StoreCriteria extends Criteria
{
    protected array $criteria = [
        'owner_id',
        'location',
        'is_share_location',
    ];

    protected function criteriaLocation(EloquentBuilder|Builder $query, $value)
    {
        $param = $this->getParam();
        $distance = request()->get('distance', 500);
        $location = $param['location'];

        if (!$location) return;

        $query->addSelect(DB::raw('ST_Distance(location, ref_geom) AS distance'))
            ->crossJoinSub("SELECT ST_MakePoint($location)::geography AS ref_geom", 'temporary')
            ->whereRaw("ST_DWithin(location, ref_geom, $distance)")
            ->orderBy('distance');
    }
}
