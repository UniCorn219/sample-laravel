<?php

namespace App\Domains\User\Jobs;

use App\Models\UserKeyword;
use Lucid\Units\Job;

class DeleteKeywordJob extends Job
{
    private $param;

    /**
     *
     * DeleteNotificationJob constructor.
     * @param $id
     * @param array $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return int
     */
    public function handle()
    {
        if (isset($this->param['is_remove_all']) && $this->param['is_remove_all']) {
            return UserKeyword::query()->where('user_id', $this->param['user_id'])->delete();
        }

        UserKeyword::query()->where('user_id', $this->param['user_id'])
            ->findOrFail($this->param['keyword_id']);

        return UserKeyword::query()
            ->where('user_id', $this->param['user_id'])
            ->where('id', $this->param['keyword_id'])
            ->delete();
    }
}
