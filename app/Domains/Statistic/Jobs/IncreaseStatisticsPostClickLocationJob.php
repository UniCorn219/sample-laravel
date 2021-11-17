<?php

namespace App\Domains\Statistic\Jobs;

use App\Models\Area;
use App\Models\EmdArea;
use App\Models\StatisticsUserLocation;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPostClickLocationJob extends QueueableJob
{
    private array $data;
    private User $user;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @param User $user
     */
    public function __construct(array $data, User $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle()
    {
        $area = $this->getArea();
        if (!$area) {
            return;
        }
        $data = [
            'user_id' => $this->user->id,
            'area_id' => $area->id,
            'statistics_date' => $this->data['statistics_date'],
            'total_clicks' => 1,
        ];
        $table = StatisticsUserLocation::query()->getModel()->getTable();
        StatisticsUserLocation::upsert(
            $data,
            [
                'statistics_date',
                'area_id',
                'user_id',
            ],
            [
                'total_clicks' => DB::raw($table . '.total_clicks + 1'),
            ]
        );
    }

    /**
     * Get area of user
     *
     * @return null|Area
     */
    private function getArea(): ?Area
    {
        $userAddress = UserAddress::where('user_id', $this->user->id)->first();
        if ($userAddress) {
            $location = explode(',', $userAddress->location);
            /* @var EmdArea $emd */
            $emd = EmdArea::whereRaw(
                'ST_Contains(geom::geometry, ST_SetSRID(ST_MakePoint(?, ?),4326))',
                [$location[0], $location[1]]
            )->first();
            if ($emd) {
                return $this->getAreaIdByEmdId($emd->id);
            }
        }

        return null;
    }

    /**
     * @param $emdId
     * @return null|Area
     */
    private function getAreaIdByEmdId($emdId): Area|null
    {
        return Area::where('original_area_id', $emdId)
            ->where('level', 2)
            ->first();
    }
}
