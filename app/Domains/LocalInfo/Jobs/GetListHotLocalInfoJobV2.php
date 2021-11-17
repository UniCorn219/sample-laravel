<?php

namespace App\Domains\LocalInfo\Jobs;

use App\Criteria\LocalInfoCriteria;
use App\Models\LocalInfo;
use App\Models\Promotion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetListHotLocalInfoJobV2 extends Job
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

        $query->orderBy(
            Promotion::available()
                ->select(DB::raw('trunc(total_promoted_user/cast(total_user as numeric), 4)'))
                ->whereColumn('promotions.localinfo_id', 'localinfo.id')
                ->limit(1)
        )
            ->orderBy(
                Promotion::available()
                    ->select('total_user')
                    ->whereColumn('promotions.localinfo_id', 'localinfo.id')
                    ->limit(1),
                'desc'
            );

        $limit = $this->param['limit'] ?? 10;
        $limit = min(50, $limit);

        return $query->paginate($limit);
    }
}
