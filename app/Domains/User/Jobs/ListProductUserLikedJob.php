<?php

namespace App\Domains\User\Jobs;

use App\Enum\ProductStatus;
use App\Models\Product;
use App\Models\ProductLike;
use Lucid\Units\Job;

class ListProductUserLikedJob extends Job
{
    private int $userId;
    private int $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $limit)
    {
        $this->userId = $userId;
        $this->limit  = $limit;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function handle()
    {
        return Product::select('products.*')->with(['owner.address', 'images', 'category'])
            ->join('product_likes', 'products.id', '=', 'product_likes.product_id')
            ->where('product_likes.user_id', $this->userId)
            ->where('products.status' , '<>', ProductStatus::HIDDEN)
            ->whereNull('products.deleted_at')
            ->whereNull('product_likes.deleted_at')
            ->orderByDesc('product_likes.created_at')
            ->cursorPaginate($this->limit);
    }
}
