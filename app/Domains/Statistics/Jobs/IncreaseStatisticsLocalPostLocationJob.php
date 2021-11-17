<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsLocalinfoLocation;
use App\Models\StatisticsLocalPostLocation;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsLocalPostLocationJob extends QueueableJob
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
        $table = StatisticsLocalPostLocation::query()
            ->getModel()
            ->getTable();
        StatisticsLocalPostLocation::upsert(
            $this->data,
            [
                'statistics_date',
                'area_id',
                'localpost_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
