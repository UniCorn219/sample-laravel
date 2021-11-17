<?php

namespace App\Domains\Promotion\Jobs;

use App\Enum\PromotionStatus;
use App\Models\Promotion;
use Lucid\Units\Job;

class ClearPromotionDailyJob extends Job
{
    /**
     * Execute the job.
     */
    public function handle()
    {
        Promotion::where('status', PromotionStatus::IN_PROGRESS)
            ->whereRaw("accepted_at + (interval '1' day * count_day) < now()")
            ->update([
                'status'     => PromotionStatus::FINISHED,
                'expired_at' => now(),
            ]);
    }
}
