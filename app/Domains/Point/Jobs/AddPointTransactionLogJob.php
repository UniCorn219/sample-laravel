<?php

namespace App\Domains\Point\Jobs;

use App\Models\PointTransactionLog;
use App\ValueObjects\Amount;
use Lucid\Units\Job;

class AddPointTransactionLogJob extends Job
{
    private int $transactionId;
    private int $type;
    private int $actorId;
    private int $userId;
    private Amount $amount;
    private Amount $balanceAmount;

    /**
     * Create a new job instance.
     *
     * @param  int  $transactionId
     * @param  int  $type
     * @param  int  $actorId
     * @param  int  $userId
     * @param  Amount  $amount
     * @param  Amount  $balanceAmount
     */
    public function __construct(
        int $transactionId,
        int $type,
        int $actorId,
        int $userId,
        Amount $amount,
        Amount $balanceAmount
    ) {
        $this->transactionId = $transactionId;
        $this->type          = $type;
        $this->actorId       = $actorId;
        $this->userId        = $userId;
        $this->amount        = $amount;
        $this->balanceAmount = $balanceAmount;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        PointTransactionLog::create([
            'transaction_id' => $this->transactionId,
            'type'           => $this->type,
            'actor_id'       => $this->actorId,
            'user_id'        => $this->userId,
            'amount'         => $this->amount,
            'balance_amount' => $this->balanceAmount,
        ]);
    }
}
