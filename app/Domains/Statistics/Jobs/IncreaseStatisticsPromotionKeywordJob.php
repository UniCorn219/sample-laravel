<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsPromotionKeyword;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPromotionKeywordJob extends QueueableJob
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
        $table = StatisticsPromotionKeyword::query()
            ->getModel()
            ->getTable();
        StatisticsPromotionKeyword::upsert(
            $this->data,
            [
                'statistics_date',
                'keyword',
                'localinfo_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
