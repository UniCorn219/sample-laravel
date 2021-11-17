<?php

namespace App\Domains\LocalInfo\Jobs;

use App\Criteria\LocalInfoCriteria;
use App\Models\LocalInfo;
use App\Models\Promotion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetListHotLocalInfoJob extends Job
{
    private array $param;
    private Collection $areas;

    /**
     * Create a new job instance.
     *
     * @param  array  $param
     * @param  Collection  $areas
     */
    public function __construct(array $param, Collection $areas)
    {
        $this->param = $param;
        $this->areas = $areas;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $query = LocalInfo::query();
        (new LocalInfoCriteria($this->param))->apply($query);

        $query->with([
            'emdArea',
            'emdArea.siggArea',
            'emdArea.siggArea.sidoArea',
            'images',
            'category',
            'store.addressMap',
            'availablePromotion',
        ]);

        $query->whereHas('availablePromotion', function ($query) {
            $query->whereHas('areas', function ($query) {
                $query->whereIn('area_id', $this->areas->pluck('id')->toArray());
            });
        });

        $limit = $this->param['limit'] ?? 10;
        $limit = min(50, $limit);

        return $query->orderBy('id')->cursorPaginate($limit);
    }
}
