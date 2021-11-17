<?php

namespace App\Domains\Transaction\Jobs;

use App\Enum\ProductOrderStatus;
use App\Models\ProductTransactionable;
use Lucid\Units\Job;

class CancelProductTransactionableJob extends Job
{
    public function __construct(
        private int $id,
        private string $reason
    ) {
    }

    public function handle()
    {
        ProductTransactionable::where('id', $this->id)
            ->update([
                'order_status'  => ProductOrderStatus::CANCELLED,
                'cancel_reason' => $this->reason,
            ]);
    }
}
