<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsPromotionPrice;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPromotionPriceJob extends QueueableJob
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
        $table = StatisticsPromotionPrice::query()
            ->getModel()
            ->getTable();
        StatisticsPromotionPrice::upsert(
            $this->data,
            [
                'statistics_date',
                'price_range',
                'localinfo_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
