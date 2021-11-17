<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsTransactionHourly;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsTransactionHourlyJob extends QueueableJob
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
        $table = StatisticsTransactionHourly::query()
            ->getModel()
            ->getTable();
        StatisticsTransactionHourly::upsert(
            $this->data,
            [
                'statistics_date',
                'statistics_hour',
                'transaction_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
