<?php

namespace App\Domains\Promotion\Jobs;

use App\Enum\PromotionStatus;
use App\Models\Promotion;
use Illuminate\Support\Collection;
use Lucid\Units\Job;

class FilterPromotionByAreaJob extends Job
{
    private Collection $areas;
    private array $ids;

    /**
     * Create a new job instance.
     *
     * @param  Collection  $areas
     * @param  array  $ids
     */
    public function __construct(Collection $areas, array $ids)
    {
        $this->areas = $areas;
        $this->ids   = $ids;
    }

    /**
     * Execute the job.
     */
    public function handle(): \Illuminate\Database\Eloquent\Collection|Collection
    {
        return Promotion::whereHas('areas', function ($query) {
            $query->whereIn('area_id', $this->areas->pluck('id')->toArray());
        })
            ->whereIn('localinfo_id', $this->ids)
            ->where('status', PromotionStatus::IN_PROGRESS)
            ->whereColumn('total_user', '>', 'total_promoted_user')
            ->get();
    }
}
