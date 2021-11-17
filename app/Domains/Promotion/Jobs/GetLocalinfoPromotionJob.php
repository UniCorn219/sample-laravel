<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Promotion;
use Lucid\Units\Job;

class GetLocalinfoPromotionJob extends Job
{
    private int $localinfoId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $localinfoId)
    {
        $this->localinfoId = $localinfoId;
    }

    /**
     * @return Promotion|null
     */
    public function handle(): Promotion|null
    {
        return Promotion::where('localinfo_id', $this->localinfoId)->first();
    }
}
