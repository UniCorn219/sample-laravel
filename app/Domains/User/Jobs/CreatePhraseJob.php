<?php

namespace App\Domains\User\Jobs;

use App\Models\UserPhrase;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\MessageBag;
use Lucid\Units\Job;

class CreatePhraseJob extends Job
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
        if ($this->checkMaxPhrase($this->param['user_id'])) {
            throw new ValidationException(new MessageBag(['Limit 10 phrase']));
        }

        return UserPhrase::query()
            ->updateOrCreate(['phrase' => $this->param['phrase']], $this->param);
    }

    /**
     * @param $userId
     * @return bool
     */
    public function checkMaxPhrase($userId)
    {
        $totalPhrase = UserPhrase::query()
            ->where('user_id', $userId)
            ->count();

        return $totalPhrase >= UserPhrase::MAX_PHRASE;
    }
}
