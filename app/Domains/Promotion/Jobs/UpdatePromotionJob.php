<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Promotion;
use Lucid\Units\Job;

class UpdatePromotionJob extends Job
{
    private int $id;
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param  int  $id
     * @param  array  $param
     */
    public function __construct(int $id, array $param)
    {
        $this->id    = $id;
        $this->param = $param;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Promotion::where('id', $this->id)->update($this->param);
    }
}
