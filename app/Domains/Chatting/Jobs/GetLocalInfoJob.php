<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\LocalInfo;
use Lucid\Units\Job;

class GetLocalInfoJob extends Job
{
    private int $localInfoId;
    private int $storeId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $localInfoId, int $storeId)
    {
        $this->localInfoId = $localInfoId;
        $this->storeId     = $storeId;
    }

    /**
     * Execute the job.
     *
     * @return LocalInfo
     */
    public function handle(): LocalInfo
    {
        return LocalInfo::query()->where([
            'id'       => $this->localInfoId,
            'store_id' => $this->storeId,
        ])->firstOrFail();
    }
}
