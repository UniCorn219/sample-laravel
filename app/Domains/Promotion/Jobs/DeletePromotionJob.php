<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Promotion;
use Lucid\Units\Job;

class DeletePromotionJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param  array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $query = Promotion::query();

        if (!empty($this->param['created_by'])) {
            $query->where('created_by', $this->param['created_by']);
        }

        $query->whereIn('id', $this->param['ids'])->delete();
    }
}
