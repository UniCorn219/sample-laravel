<?php

namespace App\Domains\User\Jobs;

use App\Models\UserDeliveryAddress;
use Lucid\Units\Job;

class DeleteUserDeliveryAddressJob extends Job
{
    private int $id;
    private int $userId;

    /**
     * DeleteUserDeliveryAddressJob constructor.
     * @param int $id
     * @param int $userId
     */
    public function __construct(int $id, int $userId)
    {
        $this->id     = $id;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userDelivery = UserDeliveryAddress::query()->findOrFail($this->id);
        $userDelivery->delete();
    }
}
