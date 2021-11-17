<?php

namespace App\Domains\Transaction\Jobs;

use App\Models\PaymentTransaction;
use App\ValueObjects\Amount;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class CreateTransactionJob extends Job
{
    public function __construct(
        private string $orderId,
        private int $transactionableId,
        private string $transactionableType,
        private int $status,
        private Amount $amount,
        private int $amountType,
        private mixed $amountRate,
    ) {
    }

    public function handle(): Model|PaymentTransaction
    {
        $transaction = PaymentTransaction::create([
            'order_id'             => $this->orderId,
            'transactionable_id'   => $this->transactionableId,
            'transactionable_type' => $this->transactionableType,
            'status'               => $this->status,
            'amount'               => $this->amount,
            'amount_type'          => $this->amountType,
            'amount_rate'          => $this->amountRate,
        ]);

        return $transaction->load('transactionable');
    }
}
