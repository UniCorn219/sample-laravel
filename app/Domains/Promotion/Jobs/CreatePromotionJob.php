<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class CreatePromotionJob extends Job
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
    public function handle(): Model|Promotion
    {
        return Promotion::create($this->param);
    }
}
