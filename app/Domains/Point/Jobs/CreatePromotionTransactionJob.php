<?php

namespace App\Domains\Point\Jobs;

use App\Enum\PointTransactionStatus;
use App\Enum\PointTransactionType;
use App\Models\PointTransaction;
use App\Models\PromotionTransactionable;
use App\ValueObjects\Amount;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class CreatePromotionTransactionJob extends Job
{
    private int $actorId;
    private int $promotionId;
    private int $type;
    private Amount $amount;

    /**
     * Create a new job instance.
     *
     * @param  int  $actorId
     * @param  int  $promotionId
     * @param  int  $type
     * @param  Amount  $amount
     */
    public function __construct(int $actorId, int $promotionId, int $type, Amount $amount)
    {
        $this->actorId     = $actorId;
        $this->promotionId = $promotionId;
        $this->type        = $type;
        $this->amount      = $amount;
    }

    /**
     * Execute the job.
     */
    public function handle(): Model|PointTransaction
    {
        $transactionable = PromotionTransactionable::create([
            'actor_id'     => $this->actorId,
            'promotion_id' => $this->promotionId,
            'type'         => $this->type,
            'amount'       => $this->amount,
        ]);

        $transaction = PointTransaction::create([
            'transactionable_id'   => $transactionable->id,
            'transactionable_type' => PointTransactionType::CREATE_PROMOTION,
            'amount'               => $this->amount,
            'status'               => PointTransactionStatus::SUCCESS,
        ]);

        return $transaction->load('transactionable');
    }
}
