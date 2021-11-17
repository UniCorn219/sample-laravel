<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsLocalinfoAge;
use App\Models\StatisticsLocalPostAge;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsLocalPostAgeJob extends QueueableJob
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
        $table = StatisticsLocalPostAge::query()
            ->getModel()
            ->getTable();
        StatisticsLocalPostAge::upsert(
            $this->data,
            [
                'statistics_date',
                'age_range',
                'localpost_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
