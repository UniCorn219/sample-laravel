<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsPromotionHourly;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPromotionHourlyJob extends QueueableJob
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
        $table = StatisticsPromotionHourly::query()
            ->getModel()
            ->getTable();
        StatisticsPromotionHourly::upsert(
            $this->data,
            [
                'statistics_date',
                'statistics_hour',
                'localinfo_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
