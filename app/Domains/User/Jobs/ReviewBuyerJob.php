<?php

namespace App\Domains\User\Jobs;

use App\Models\UserReview;
use Lucid\Units\Job;
use App\Enum\ProductStatus;
use App\Models\Product;

class ReviewBuyerJob extends Job
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
     * @return array|null[]
     */
    public function handle(): array
    {
        $productId = $this->param['product_id'];
        $product   = Product::query()->findOrFail($productId);

        if (in_array($product->status, [ProductStatus::RESERVED, ProductStatus::SELLING, ProductStatus::SOLD])) {
            $dataReview = $this->param;

            $review = UserReview::create($dataReview);

            $product->update([
                'status'     => ProductStatus::COMPLETE,
                'buyer_id'   => $this->param['buyer_id'],
                'buyer_name' => $this->param['buyer_name'],
            ]);

            return [$product, $review];
        }

        return [null, null];
    }
}
