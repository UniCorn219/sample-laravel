<?php

namespace App\Domains\Product\Jobs;

use App\Enum\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Lucid\Units\Job;

class GetProductSellingByAuthJob extends Job
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
     * @return CursorPaginator|null
     */
    public function handle(): ?CursorPaginator
    {
        $params = $this->params;
        $limit = $params['limit'];
        $hideAuthor = $params['hide_author_id'];
        $productId = $params['productId'];
        $product = Product::findOrFail($productId);
        $authorId = $product->author_id;
        $query = Product::with('images');

        if (count($hideAuthor)) {
            $query->whereNotIn('author_id', $hideAuthor);
        }

        return $query
            ->where(['author_id' => $authorId, 'status' => ProductStatus::SELLING])
            ->whereNotIn('id', [$product->id])
            ->whereNull('blocked_by')
            ->select('id', 'title', 'price', 'content')
            ->orderByDesc('id')
            ->cursorPaginate($limit);
    }
}
