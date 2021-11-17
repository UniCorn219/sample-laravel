<?php

namespace App\Domains\Product\Jobs;

use App\Enum\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class GetProductSellingByCategoryJob extends Job
{
    const LIMIT_PRODUCT_SELLING_BY_CATEGORY = 20;

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
     * @return Collection|array
     */
    public function handle(): Collection|array
    {
        $params = $this->params;
        $productId = $params['productId'];
        $hideAuthor = $params['hide_author_id'];
        $product = Product::findOrFail($productId);
        $query = Product::with('images');

        if (count($hideAuthor)) {
            $query->whereNotIn('author_id', $hideAuthor);
        }

        return $query
            ->where(['category_id' => $product->category_id, 'status' => ProductStatus::SELLING])
            ->select('id', 'title', 'price', 'content')
            ->whereNotIn('id', [$product->id])
            ->whereNull('blocked_by')
            ->orderByDesc('id')
            ->limit(self::LIMIT_PRODUCT_SELLING_BY_CATEGORY)
            ->get();
    }
}
