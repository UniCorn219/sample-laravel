<?php

namespace App\Domains\Transaction\Jobs;

use App\Models\PromotionTransactionable;
use App\ValueObjects\Amount;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class CreatePromotionTransactionableJob extends Job
{
    public function __construct(
        private int $actorId,
        private int $promotionId,
        private int $type,
        private Amount $amount
    )
    {
    }

    public function handle(): Model|PromotionTransactionable
    {
        return PromotionTransactionable::create([
            'actor_id'     => $this->actorId,
            'promotion_id' => $this->promotionId,
            'type'         => $this->type,
            'amount'       => $this->amount,
        ]);
    }
}
