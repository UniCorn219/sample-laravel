<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsTransactionCategory;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsTransactionCategoryJob extends QueueableJob
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
        $table = StatisticsTransactionCategory::query()
            ->getModel()
            ->getTable();
        StatisticsTransactionCategory::upsert(
            $this->data,
            [
                'statistics_date',
                'category_id',
                'transaction_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
