<?php

namespace App\Domains\Promotion\Jobs;

use App\Enum\PromotionStatus;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseTotalPromotedUserJob extends QueueableJob
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
     *
     * @throws Throwable
     */
    public function handle()
    {
        DB::transaction(function () {
            /** @var Promotion|null $promotion */
            $promotion = Promotion::useWritePdo()
                ->where('id', $this->id)
                ->lockForUpdate()
                ->first();

            if (!$promotion) {
                return;
            }

            // sometime, action in queue maybe count double when total_promoted_user reached to total_user
            $totalPromotedUser = min($promotion->total_promoted_user + 1, $promotion->total_user);

            $update = ['total_promoted_user' => $totalPromotedUser];

            if ($totalPromotedUser == $promotion->total_user) {
                $update['status'] = PromotionStatus::FINISHED;
            }

            $promotion->update($update);
        });
    }
}
