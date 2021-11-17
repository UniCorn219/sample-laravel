<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsTransactionKeyword;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsTransactionKeywordJob extends QueueableJob
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
        $table = StatisticsTransactionKeyword::query()
            ->getModel()
            ->getTable();
        StatisticsTransactionKeyword::upsert(
            $this->data,
            [
                'statistics_date',
                'keyword',
                'transaction_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
