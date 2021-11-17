<?php

namespace App\Domains\Statistics\Jobs;

use App\Models\StatisticsLocalinfoKeyword;
use App\Models\StatisticsLocalPostKeyword;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsLocalPostKeywordJob extends QueueableJob
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
        $table = StatisticsLocalPostKeyword::query()
            ->getModel()
            ->getTable();
        StatisticsLocalPostKeyword::upsert(
            $this->data,
            [
                'statistics_date',
                'keyword',
                'localpost_id',
            ],
            [
                'total_clicks' => DB::raw($table.'.total_clicks + 1'),
            ]
        );
    }
}
