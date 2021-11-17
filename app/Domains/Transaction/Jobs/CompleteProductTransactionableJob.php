<?php

namespace App\Domains\Transaction\Jobs;

use App\Enum\ProductOrderStatus;
use App\Models\ProductTransactionable;
use Lucid\Units\Job;

class CompleteProductTransactionableJob extends Job
{
    public function __construct(
        private int $id
    ) {
    }

    public function handle()
    {
        ProductTransactionable::where('id', $this->id)
            ->update(['order_status'  => ProductOrderStatus::RECEIVED_PRODUCT]);
    }
}
