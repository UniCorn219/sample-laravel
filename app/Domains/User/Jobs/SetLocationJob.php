<?php

namespace App\Domains\User\Jobs;

use App\Models\UserAddress;
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
        UserAddress::where('user_id', $this->param['user_id'])->delete();

        UserAddress::updateOrCreate(['user_id' => $this->param['user_id']], $this->param);
    }
}
