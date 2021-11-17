<?php

namespace App\Domains\Store\Jobs;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Store;
use App\Models\StoreReport;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class ReportStoreJob extends Job
{
    private array $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return Model|StoreReport
     * @throws ResourceNotFoundException
     */
    public function handle(): Model|StoreReport
    {
        $payload = $this->payload;
        $storeId = $payload['store_id'];
        if (!Store::find($storeId)) {
            throw new ResourceNotFoundException();
        }

        return StoreReport::create($payload);
    }
}
