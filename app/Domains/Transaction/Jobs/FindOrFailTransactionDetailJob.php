<?php

namespace App\Domains\Transaction\Jobs;

use App\Models\PaymentTransaction;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class FindOrFailTransactionDetailJob extends Job
{
    public function __construct(
        private int $id
    ) {
    }

    public function handle(): Model|PaymentTransaction
    {
        $transaction = PaymentTransaction::findOrFail($this->id);

        return $transaction->load('transactionable');
    }
}
