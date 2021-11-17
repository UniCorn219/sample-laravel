<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Promotion;
use Lucid\Units\Job;

class SyncPromotionCategoryJob extends Job
{
    private Promotion $promotion;
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param  Promotion  $promotion
     * @param  array  $param
     */
    public function __construct(Promotion $promotion, array $param)
    {
        $this->promotion = $promotion;
        $this->param     = $param;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->promotion->categories()->sync($this->param);
    }
}
