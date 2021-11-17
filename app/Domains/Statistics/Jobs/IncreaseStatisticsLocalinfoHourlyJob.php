<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsLocalinfoHourly;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsLocalinfoHourlyJob extends QueueableJob
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
        $table = StatisticsLocalinfoHourly::query()
            ->getModel()
            ->getTable();
        StatisticsLocalinfoHourly::upsert(
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
