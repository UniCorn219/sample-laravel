<?php

namespace App\Domains\User\Jobs;

use App\Models\Product;
use Lucid\Units\Job;

class GetListSellerReviewProductJob extends Job
{
    private array $params;

    /**
     * Create a new job instance.
     *
     * @return void
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
            ->where('products.id', '=', $this->params['product_id'])
            ->where('products.author_id', '=', $this->params['user_id'])
            ->where('user_reviews.reviewer_id', '=', $this->params['user_id'])
            ->select('products.buyer_id', 'user_reviews.*')
            ->with('buyer', function($query) {
                $query->select('id', 'name', 'nickname');
            })
            ->first();
    }
}
