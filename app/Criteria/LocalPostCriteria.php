<?php

namespace App\Criteria;

use Illuminate\Database\Query\Builder;

class LocalPostCriteria extends Criteria
{
    protected array $criteria = [
        'keyword',
        'category_id',
        'emd_area_id',
        'localpost_blocked_ids',
        'hide_author_id',
        'radius_long_lat',
    ];

    protected function criteriaKeyword(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->where(function (\Illuminate\Database\Eloquent\Builder|Builder $query) use ($value) {
            $query->orWhere('content', 'like', "%$value%")
                ->orWhere('content', 'like', "%".strtolower($value)."%");
        });
    }

    protected function criteriaLocalpostBlockedIds(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->whereNotIn('id', $value);
    }

    protected function criteriaHideAuthorId(\Illuminate\Database\Eloquent\Builder|Builder $query, $value)
    {
        $query->whereNotIn('author_id', $value);
    }

    protected function criteriaRadiusLongLat(\Illuminate\Database\Eloquent\Builder|Builder $query, $values)
    {
        if (!isset($values['long']) || !isset($values['lat']) || !isset($values['radius'])) {
            return;
        }

        $userLocation = implode(',', [$values['long'], $values['lat']]);
        $radius = $values['radius'];
        $query->crossJoinSub("SELECT ST_MakePoint($userLocation)::geography AS ref_geom", 'temporary')
            ->whereRaw("ST_DWithin(localpost.location, ref_geom, $radius)")
            ->whereNotNull('localpost.location');
    }
}
