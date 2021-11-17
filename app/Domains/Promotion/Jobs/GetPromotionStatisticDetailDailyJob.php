<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\PromotionStatistic;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;

class GetPromotionStatisticDetailDailyJob extends Job
{
    private int $id;
    private Carbon $date;

    /**
     * Create a new job instance.
     *
     * @param  int  $id
     * @param  Carbon  $date
     */
    public function __construct(int $id, Carbon $date)
    {
        $this->id   = $id;
        $this->date = $date;
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
            ->whereDate('statistic_date', $this->date)
            ->groupBy('promotion_id')
            ->first();
    }
}
