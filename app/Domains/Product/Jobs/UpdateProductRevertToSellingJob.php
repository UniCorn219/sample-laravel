<?php

namespace App\Domains\Product\Jobs;

use App\Enum\ProductStatus;
use App\Models\Product;
use Lucid\Units\Job;

class UpdateProductRevertToSellingJob extends Job
{
    public function __construct(
        private int $id
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Product::where('id', $this->id)
            ->update([
                'status'   => ProductStatus::SELLING,
                'buyer_id' => null,
            ]);
    }
}
