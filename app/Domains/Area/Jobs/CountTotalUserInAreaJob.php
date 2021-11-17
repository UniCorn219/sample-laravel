<?php

namespace App\Domains\Area\Jobs;

use App\Models\Area;
use App\Models\UserAddress;
use Lucid\Units\QueueableJob;

class CountTotalUserInAreaJob extends QueueableJob
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param  array  $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $areaLevel3 = $this->updateAreaLevel3();

        if (!$areaLevel3) {
            return;
        }

        $areaLevel2 = $this->updateAreaLevel2($areaLevel3);

        if (!$areaLevel2) {
            return;
        }

        $this->updateAreaLevel1($areaLevel2);
    }

    protected function updateAreaLevel3(): Area|null
    {
        $areaLevel3 = Area::where('original_area_id', $this->param['emd_area_id'])
            ->where('level', 3)
            ->first();

        if ($areaLevel3) {
            $totalUserLevel3 = UserAddress::where('emd_area_id', $areaLevel3->original_area_id)->count();
            $areaLevel3->update(['total_user' => $totalUserLevel3]);
        }

        return $areaLevel3;
    }

    protected function updateAreaLevel2(Area $areaLevel3): Area|null
    {
        $areaLevel2 = Area::where('original_area_id', $areaLevel3->original_parent_area_id)
            ->where('level', 2)
            ->first();

        if ($areaLevel2) {
            $children = Area::where('original_parent_area_id', $areaLevel2->original_area_id)
                ->where('level', 3)
                ->pluck('original_area_id')
                ->toArray();

            $totalUserLevel2 = UserAddress::whereIn('emd_area_id', $children)->count();
            $areaLevel2->update(['total_user' => $totalUserLevel2]);
        }

        return $areaLevel2;
    }

    protected function updateAreaLevel1(Area $areaLevel2)
    {
        $areaLevel1 = Area::where('original_area_id', $areaLevel2->original_parent_area_id)
            ->where('level', 1)
            ->first();

        if (!$areaLevel1) {
            return;
        }

        $childrenLevel2 = Area::where('original_parent_area_id', $areaLevel1->original_area_id)
            ->where('level', 2)
            ->pluck('original_area_id')
            ->toArray();
        $childrenLevel3 = Area::whereIn('original_parent_area_id', $childrenLevel2)
            ->where('level', 2)
            ->pluck('original_area_id')
            ->toArray();

        $totalUserLevel1 = UserAddress::whereIn('emd_area_id', $childrenLevel3)->count();
        $areaLevel1->update(['total_user' => $totalUserLevel1]);
    }
}
