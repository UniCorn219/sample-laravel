<?php

namespace App\Domains\User\Jobs;

use App\Models\UserPhrase;
use Lucid\Units\Job;

class ListPhrasedJob extends Job
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
        return UserPhrase::query()
            ->where('user_id', $this->param['user_id'])
            ->limit(UserPhrase::MAX_PHRASE)
            ->get();
    }
}
