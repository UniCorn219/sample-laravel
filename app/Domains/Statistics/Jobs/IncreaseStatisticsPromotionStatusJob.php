<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsPromotionStatus;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPromotionStatusJob extends QueueableJob
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
        $table = StatisticsPromotionStatus::query()
            ->getModel()
            ->getTable();
        StatisticsPromotionStatus::upsert(
            $this->data,
            [
                'statistics_date',
                'status',
                'localinfo_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
