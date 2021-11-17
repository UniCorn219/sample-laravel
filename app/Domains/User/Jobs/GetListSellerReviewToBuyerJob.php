<?php

namespace App\Domains\User\Jobs;

use App\Models\Product;
use Lucid\Units\Job;
use Illuminate\Support\Facades\DB;
use App\Enum\ProductOrderStatus;

class GetListSellerReviewToBuyerJob extends Job
{

    private array $params;

    /**
     * Create a new job instance.
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        return Product::query()
            ->join('user_reviews', 'products.id', '=', 'user_reviews.product_id')
            ->where('products.buyer_id', '=', $this->params['user_id'])
            ->whereRaw( 
                DB::raw('user_reviews.reviewer_id = products.author_id') 
            )
            ->where('user_reviews.receiver_id', '=', $this->params['user_id'])
            ->select('products.id', 'user_reviews.id as review_id', 'user_reviews.value', 'user_reviews.created_at', 'user_reviews.updated_at')
            ->with('transactionable', function ($query) {
                $query->where('order_status', '=', ProductOrderStatus::RECEIVED_PRODUCT);
            })
            ->orderByDesc('user_reviews.id')
            ->paginate($this->params['limit']);
    }
}
