<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class UpdateUserSettingJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param  array  $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     *
     * @return UserSetting|Model
     */
    public function handle(): UserSetting|Model
    {
        return UserSetting::updateOrCreate([
            'user_id' => $this->param['user_id']
        ], $this->param);
    }
}
