<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsPromotionLocation;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPromotionLocationJob extends QueueableJob
{
    private array $data;

    /**
     * Create a new job instance.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle()
    {
        $table = StatisticsPromotionLocation::query()
            ->getModel()
            ->getTable();
        StatisticsPromotionLocation::upsert(
            $this->data,
            [
                'statistics_date',
                'area_id',
                'localinfo_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
