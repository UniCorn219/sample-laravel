<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsTransactionLocation;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsTransactionLocationJob extends QueueableJob
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
        $table = StatisticsTransactionLocation::query()
            ->getModel()
            ->getTable();
        StatisticsTransactionLocation::upsert(
            $this->data,
            [
                'statistics_date',
                'area_id',
                'transaction_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
