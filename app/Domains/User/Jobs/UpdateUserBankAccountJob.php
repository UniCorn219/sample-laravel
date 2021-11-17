<?php

namespace App\Domains\User\Jobs;

use App\Models\UserBankAccount;
use Lucid\Units\Job;

class UpdateUserBankAccountJob extends Job
{
    private int $bankAccountId;
    private array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $bankAccountId, array $data)
    {
        $this->bankAccountId = $bankAccountId;
        $this->data          = $data;
    }

    /**
     * @return bool|int
     */
    public function handle()
    {
        $userBankAccountInfo = UserBankAccount::query()->findOrFail($this->bankAccountId);

        if ($this->data['is_default']) {
            $this->changeNormalBankAccount();
        }

        return $userBankAccountInfo->update($this->data);
    }

    /**
     * @return void
     */
    public function changeNormalBankAccount()
    {
        $defaultBankAccount = UserBankAccount::query()
            ->where('is_default', true)
            ->where('id', '!=', $this->bankAccountId)
            ->first();

        if ($defaultBankAccount) {
            $defaultBankAccount->is_default = false;
            $defaultBankAccount->save();
        }
    }
}
