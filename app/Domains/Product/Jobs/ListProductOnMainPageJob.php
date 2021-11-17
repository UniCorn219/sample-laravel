<?php

namespace App\Domains\Product\Jobs;

use App\Enum\ProductStatus;
use App\Models\Product;
use App\Models\SortSetting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class ListProductOnMainPageJob extends Job
{
    private int $option;

    const LIMIT_DEFAULT = 10;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $option)
    {
        $this->option = $option;
    }

    /**
     * Execute the job.
     *
     * @return Collection|LengthAwarePaginator
     */
    public function handle(): Collection|LengthAwarePaginator
    {
        return match ($this->option) {
            SortSetting::PRODUCT_TOTAL_LIKE_SORT => $this->getProductListByLiked(),
            SortSetting::PRODUCT_TOTAL_VIEW_SORT => $this->getProductListByViewer(),
            SortSetting::PRODUCT_ADMIN_SORT => $this->getProductListByManually(),
            default => $this->getProductListByNewest(),
        };
    }

    /**
     * @return Collection
     */
    private function getProductListByNewest(): Collection
    {
        return Product::where('status', ProductStatus::SELLING)
            ->orderByDesc('id')
            ->limit(self::LIMIT_DEFAULT)
            ->get();
    }

    /**
     * @return Collection
     */
    private function getProductListByLiked(): Collection
    {
        return Product::where('status', ProductStatus::SELLING)
            ->orderByDesc('total_like')
            ->limit(self::LIMIT_DEFAULT)
            ->get();
    }

    /**
     * @return Collection
     */
    private function getProductListByViewer(): Collection
    {
        return Product::where('status', ProductStatus::SELLING)
            ->orderByDesc('total_view')
            ->limit(self::LIMIT_DEFAULT)
            ->get();
    }

    /**
     * @return Collection
     */
    private function getProductListByManually(): Collection
    {
        return Product::with('sortOptions:id,product_id')
            ->join('product_sort_options', 'product_sort_options.product_id', '=', 'products.id')
            ->whereNull('product_sort_options.deleted_at')
            ->where('products.status', ProductStatus::SELLING)
            ->select('products.*')
            ->orderByDesc('product_sort_options.updated_at')
            ->limit(self::LIMIT_DEFAULT)
            ->get();
    }
}
