<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsLocalinfoCategory;
use App\Models\StatisticsLocalPostCategory;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsLocalPostCategoryJob extends QueueableJob
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
        $table = StatisticsLocalPostCategory::query()
            ->getModel()
            ->getTable();
        StatisticsLocalPostCategory::upsert(
            $this->data,
            [
                'statistics_date',
                'category_id',
                'localpost_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
