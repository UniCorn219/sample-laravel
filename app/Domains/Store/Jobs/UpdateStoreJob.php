<?php

namespace App\Domains\Store\Jobs;

use App\Models\Store;
use Illuminate\Auth\Access\AuthorizationException;
use Lucid\Units\Job;
use Throwable;

class UpdateStoreJob extends Job
{
    private int $storeId;
    private array $data;
    private int $authId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $storeId, int $authId, array $data)
    {
        $this->storeId = $storeId;
        $this->data = $data;
        $this->authId = $authId;
    }

    /**
     * Execute the job.
     *
     * @return bool
     * @throws Throwable
     */
    public function handle(): bool
    {
        $storeId = $this->storeId;

        $storeDetail = Store::findOrFail($storeId);

        if ($storeDetail) {
            throw_if($storeDetail->owner_id !== $this->authId, AuthorizationException::class);
        }

        return $storeDetail->update($this->data);
    }
}
