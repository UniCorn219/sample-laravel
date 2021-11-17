<?php

namespace App\Domains\Store\Jobs;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;
use Throwable;

class FindOrFailStoreDetailJob extends Job
{
    private int   $storeId;
    private ?int  $ownerId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $storeId, int|null $ownerId = null)
    {
        $this->storeId = $storeId;
        $this->ownerId = $ownerId;
    }

    /**
     * @return Store|Store[]|Collection|Model
     * @throws Throwable
     */
    public function handle(): array|Model|Collection|Store
    {
        $store = Store::findOrFail($this->storeId);

        if (!empty($this->ownerId)) {
            throw_if($this->ownerId != $store->owner_id, ResourceNotFoundException::class);
        }

        return $store;
    }
}
