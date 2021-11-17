<?php

namespace App\Domains\Point\Jobs;

use App\Enum\PointTransactionStatus;
use App\Enum\PointTransactionType;
use App\Exceptions\BusinessException;
use App\Models\PointTransaction;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;
use Throwable;

class AcceptTransferJob extends Job
{
    private int $id;
    private int $appliedBy;

    /**
     * Create a new job instance.
     *
     * @param  int  $id
     * @param  int  $appliedBy
     */
    public function __construct(int $id, int $appliedBy)
    {
        $this->id = $id;
        $this->appliedBy = $appliedBy;
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle(): Model|PointTransaction
    {
        $transaction = PointTransaction::whereHasMorph(
            'transactionable',
            [PointTransactionType::TRANSFER]
        )
            ->where('id', $this->id)
            ->firstOrFail();

        throw_if(
            $transaction->status != PointTransactionStatus::WAITING,
            BusinessException::class,
            __('messages.payment.transfer_transaction_is_not_valid')
        );

        $transaction->update(['status' => PointTransactionStatus::SUCCESS]);
        $transaction->transactionable()->update(['applied_by' => $this->appliedBy]);

        return $transaction;
    }
}
