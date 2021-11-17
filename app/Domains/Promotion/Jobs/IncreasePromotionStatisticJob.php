<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\PromotionStatistic;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;

class IncreasePromotionStatisticJob extends QueueableJob
{
    private int $id;
    private string $key;

    /**
     * Create a new job instance.
     *
     * @param  int  $id
     * @param  string  $key
     */
    public function __construct(int $id, string $key)
    {
        $this->id  = $id;
        $this->key = $key;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        PromotionStatistic::upsert(
            [
                'promotion_id'   => $this->id,
                'statistic_date' => today(),
                $this->key       => 1,
            ],
            ['promotion_id', 'statistic_date'],
            [
                $this->key => DB::raw('promotion_statistic.'.$this->key.' + 1'),
            ]
        );
    }
}
