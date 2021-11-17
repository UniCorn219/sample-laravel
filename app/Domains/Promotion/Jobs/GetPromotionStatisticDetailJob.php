<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\PromotionStatistic;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetPromotionStatisticDetailJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @param  int  $id
     */
    public function __construct(int $id)
    {
        $this->id  = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): object|null
    {
        return PromotionStatistic::where('promotion_id', $this->id)
            ->select([
                DB::raw("sum(display_count) as display_count"),
                DB::raw("sum(reach_count) as reach_count"),
                DB::raw("sum(click_count) as click_count"),
            ])
            ->groupBy('promotion_id')
            ->first();
    }
}
