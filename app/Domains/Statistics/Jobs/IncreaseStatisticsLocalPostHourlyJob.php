<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsLocalinfoHourly;
use App\Models\StatisticsLocalPostHourly;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsLocalPostHourlyJob extends QueueableJob
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
        $table = StatisticsLocalPostHourly::query()
            ->getModel()
            ->getTable();
        StatisticsLocalPostHourly::upsert(
            $this->data,
            [
                'statistics_date',
                'statistics_hour',
                'localpost_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
