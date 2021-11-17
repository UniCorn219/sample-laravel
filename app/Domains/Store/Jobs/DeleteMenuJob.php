<?php

namespace App\Domains\Store\Jobs;

use App\Models\MenuStore;
use Lucid\Units\Job;

class DeleteMenuJob extends Job
{
    private int   $storeId;
    private array $ids;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $storeId, array $ids)
    {
        $this->storeId = $storeId;
        $this->ids     = $ids;
    }

    /**
     * @return bool|int
     */
    public function handle(): bool|int
    {
        return MenuStore::where('store_id', $this->storeId)
            ->whereIn('id', $this->ids)
            ->delete();
    }
}
