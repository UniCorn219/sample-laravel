<?php

namespace App\Domains\Store\Jobs;

use App\Models\StoreAddress;
use Lucid\Units\Job;

class SetLocationJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param array $param
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
        StoreAddress::updateOrCreate(['store_id' => $this->param['store_id']], $this->param);
    }
}
