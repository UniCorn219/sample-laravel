<?php

namespace App\Domains\Product\Jobs;

use App\Enum\ProductStatus;
use App\Models\Product;
use Lucid\Units\Job;

class UpdateProductIsOrderingJob extends Job
{
    public function __construct(
        private int $id,
        private int $buyerId
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Product::where('id', $this->id)
            ->update([
                'status'   => ProductStatus::ORDERING,
                'buyer_id' => $this->buyerId,
            ]);
    }
}
