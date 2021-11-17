<?php

namespace App\Domains\LocalInfo\Jobs;

use App\Criteria\LocalInfoCriteria;
use App\Enum\LocalInfoType;
use App\Models\LocalInfo;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\CursorPaginator;
use Lucid\Units\Job;

class GetListRecommendLocalInfoJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     *
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $query = LocalInfo::query();
        (new LocalInfoCriteria($this->param))->apply($query);
        $localInfoIds = $query->pluck('id')->toArray();
        $limit = $this->param['limit'] ?? 5;
        $limit = min(50, $limit);

        if (empty($localInfoIds)) {
            $items = [];
            $perPage = $limit;
            $cursor = null;
            $options = [];
            return Container::getInstance()->makeWith(CursorPaginator::class, compact(
                'items', 'perPage', 'cursor', 'options'
            ));
        }

        $query = $query->select('localinfo.*')
            ->join('stores', 'stores.id', '=', 'localinfo.store_id')
            ->whereIn('localinfo.id', $localInfoIds);

        if (isset($this->param['location'])) {
            $userLocation = $this->param['location'];
            $query->crossJoinSub("SELECT ST_MakePoint($userLocation)::geography AS ref_geom", 'temporary')
                ->whereRaw("ST_DWithin(localinfo.location, ref_geom, 500)");
        }

        $query->with(['emdArea', 'emdArea.siggArea', 'emdArea.siggArea.sidoArea', 'images', 'category', 'store.addressMap']);

        return $query->orderByDesc('localinfo.total_like')
            ->orderByDesc('stores.total_follow')
            ->orderByDesc('localinfo.total_search')
            ->limit(LocalInfoType::RECOMMEND_LIMIT)
            ->cursorPaginate($limit);
    }
}
