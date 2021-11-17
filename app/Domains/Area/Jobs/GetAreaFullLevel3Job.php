<?php

namespace App\Domains\Area\Jobs;

use App\Models\Area;
use Illuminate\Support\Collection;
use Lucid\Units\Job;

class GetAreaFullLevel3Job extends Job
{
    private int $originalAreaId;

    /**
     * Create a new job instance.
     *
     * @param  int  $originalAreaId
     */
    public function __construct(int $originalAreaId)
    {
        $this->originalAreaId = $originalAreaId;
    }

    /**
     * Execute the job.
     */
    public function handle(): Collection
    {
        $areaLevel3 = Area::where('original_area_id', $this->originalAreaId)
            ->where('level', 3)
            ->first();

        if (!$areaLevel3) {
            return collect([]);
        }

        $areaLevel2 = Area::where('original_area_id', $areaLevel3->original_parent_area_id)
            ->where('level', 2)
            ->first();

        if (!$areaLevel2) {
            return collect([3 => $areaLevel3]);
        }

        $areaLevel1 = Area::where('original_area_id', $areaLevel2->original_parent_area_id)
            ->where('level', 1)
            ->first();

        if (!$areaLevel1) {
            return collect([3 => $areaLevel3, 2 => $areaLevel2]);
        }

        return collect([3 => $areaLevel3, 2 => $areaLevel2, 1 => $areaLevel1]);
    }
}
