<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Lucid\Units\Job;

class UpdateProfileJob extends Job
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
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::find($this->param['user_id']);
        $user->update([
            'nickname' => $this->param['data_update_profile']['nickname'],
            'avatar'    => $this->param['data_update_profile']['avatar'],
        ]);

        return $user->refresh();
    }
}
