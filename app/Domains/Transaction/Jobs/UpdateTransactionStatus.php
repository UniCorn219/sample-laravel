<?php

namespace App\Domains\Transaction\Jobs;

use App\Models\PaymentTransaction;
use Lucid\Units\Job;

class UpdateTransactionStatus extends Job
{
    public function __construct(
        private int $id,
        private int $status
    ) {
    }

    public function handle()
    {
        PaymentTransaction::where('id', $this->id)
            ->update(['status' => $this->status]);
    }
}
