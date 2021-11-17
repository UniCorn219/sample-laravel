<?php

namespace App\Domains\User\Jobs;

use App\Models\UserReview;
use Lucid\Units\Job;
use App\Enum\ProductStatus;
use App\Models\Product;

class ReviewSellerJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $productId = $this->param['product_id'];
        $product   = Product::find($productId);

        if (in_array($product->status, [ProductStatus::SOLD, ProductStatus::COMPLETE])) {
            $dataReview                = $this->param;
            $dataReview['receiver_id'] = $product->author_id;

            $review = UserReview::create($dataReview);

            return [$product, $review];
        }

        return [null, null];
    }
}
