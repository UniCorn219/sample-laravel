<?php

namespace App\Domains\User\Jobs;

use App\Models\UserBankAccount;
use Illuminate\Validation\ValidationException;
use Lucid\Units\Job;

class CreateUserBankAccountJob extends Job
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
     * @return mixed
     */
    public function handle()
    {
        if ($this->checkMaxBankAccount($this->param['user_id'])) {
            throw ValidationException::withMessages(['Limit ' . UserBankAccount::MAX_INFO . 'bank account setting.']);
        }

        if ($this->param['is_default']) {
            $this->changeNormalBankAccount();
        }

        return UserBankAccount::query()
            ->create($this->param);
    }

    /**
     * @param $userId
     * @return bool
     */
    public function checkMaxBankAccount($userId)
    {
        $totalBankAccount = UserBankAccount::query()
            ->where('user_id', $userId)
            ->count();

        return $totalBankAccount >= UserBankAccount::MAX_INFO;
    }

    /**
     * @return void
     */
    public function changeNormalBankAccount()
    {
        $defaultBankAccount = UserBankAccount::query()->where('is_default', true)->first();

        if ($defaultBankAccount) {
            $defaultBankAccount->is_default = false;
            $defaultBankAccount->save();
        }
    }
}
