<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use App\Models\UserSetting;
use Lucid\Units\Job;

class GetUserSettingJob extends Job
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
     * @return null|UserSetting
     */
    public function handle(): UserSetting|null
    {
        return UserSetting::where([
            'user_id' => $this->param['user_id']
        ])->first();
    }
}
