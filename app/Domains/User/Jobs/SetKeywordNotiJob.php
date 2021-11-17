<?php

namespace App\Domains\User\Jobs;

use App\Models\UserKeyword;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Lucid\Units\Job;

class SetKeywordNotiJob extends Job
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
     * @throws ValidationException
     */
    public function handle()
    {
        if ($this->checkMaxKeyword($this->param['user_id'])) {
            throw new ValidationException(new MessageBag('Limit 10 keyword'));
        }

        return UserKeyword::updateOrCreate(['keyword' => $this->param['keyword']], $this->param);
    }

    /**
     * @param $userId
     * @return bool
     */
    public function checkMaxKeyword($userId)
    {
        $totalKeyword = UserKeyword::where('user_id', $userId)->count();

        return $totalKeyword > UserKeyword::MAX_KEYWORD;
    }
}
