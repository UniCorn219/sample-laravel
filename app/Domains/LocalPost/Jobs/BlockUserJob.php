<?php

namespace App\Domains\LocalPost\Jobs;

use App\Models\LocalPostBlocking;
use Lucid\Units\Job;

class BlockUserJob extends Job
{
    private int $userId;
    private int $localPostId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $localPostId)
    {
        $this->userId = $userId;
        $this->localPostId = $localPostId;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle(): array
    {
        $data = [
            'user_id' => $this->userId,
            'localpost_id' => $this->localPostId,
        ];
        $resourceDetail = LocalPostBlocking::where($data)->first();

        if ($resourceDetail) {
            $resourceDetail->delete();
            return ['un_block' => true];
        } else {
            LocalPostBlocking::create($data);
            return ['block' => true];
        }
    }
}
