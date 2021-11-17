<?php

namespace App\Domains\Point\Jobs;

use App\Enum\PointTransactionStatus;
use App\Enum\PointTransactionType;
use App\Models\PointTransaction;
use App\Models\TransferTransactionable;
use App\ValueObjects\Amount;
use Lucid\Units\Job;

class RequestTransferJob extends Job
{
    private int $userId;
    private Amount $amount;
    private int $bankId;

    /**
     * Create a new job instance.
     *
     * @param  int  $userId
     * @param  Amount  $amount
     * @param  int  $bankId
     */
    public function __construct(int $userId, Amount $amount, int $bankId)
    {
        $this->userId = $userId;
        $this->amount = $amount;
        $this->bankId = $bankId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $transactionable = TransferTransactionable::create([
            'user_id' => $this->userId,
            'bank_id' => $this->bankId,
            'amount'  => $this->amount,
        ]);

        $transaction = PointTransaction::create([
            'transactionable_id'   => $transactionable->id,
            'transactionable_type' => PointTransactionType::TRANSFER,
            'amount'               => $this->amount,
            'status'               => PointTransactionStatus::WAITING,
        ]);

        return $transaction->load('transactionable');
    }
}
