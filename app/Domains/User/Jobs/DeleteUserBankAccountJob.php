<?php

namespace App\Domains\User\Jobs;

use App\Models\UserBankAccount;
use Lucid\Units\Job;

class DeleteUserBankAccountJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        $userDelivery = UserBankAccount::query()->findOrFail($this->id);

        return $userDelivery->delete();
    }
}
