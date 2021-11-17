<?php

namespace App\Domains\Promotion\Jobs;

use App\Enum\PromotionStatus;
use App\Models\Promotion;
use Lucid\Units\QueueableJob;

class FinishPromotionJob extends QueueableJob
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @param  int  $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Promotion::where('id', $this->id)
            ->update([
                'status'     => PromotionStatus::FINISHED,
                'expired_at' => now(),
            ]);
    }
}
