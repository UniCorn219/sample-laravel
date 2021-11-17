<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsTransactionAge;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsTransactionAgeJob extends QueueableJob
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
        $table = StatisticsTransactionAge::query()
            ->getModel()
            ->getTable();
        StatisticsTransactionAge::upsert(
            $this->data,
            [
                'statistics_date',
                'age_range',
                'transaction_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
