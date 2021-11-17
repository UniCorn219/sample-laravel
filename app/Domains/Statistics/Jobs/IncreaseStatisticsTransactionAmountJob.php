<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsTransactionAmount;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsTransactionAmountJob extends QueueableJob
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
        $table = StatisticsTransactionAmount::query()
            ->getModel()
            ->getTable();
        StatisticsTransactionAmount::upsert(
            $this->data,
            [
                'statistics_date',
                'amount_range',
                'transaction_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
