<?php

namespace App\Domains\User\Jobs;

use App\Models\UserKeyword;
use Lucid\Units\Job;

class ListKeywordJob extends Job
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

    public function handle()
    {
        return UserKeyword::query()
            ->where('user_id', $this->param['user_id'])
            ->orderBy('id', 'DESC')
            ->get();
    }
}
