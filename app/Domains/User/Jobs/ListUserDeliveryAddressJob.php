<?php

namespace App\Domains\User\Jobs;

use App\Models\UserDeliveryAddress;
use Lucid\Units\Job;

class ListUserDeliveryAddressJob extends Job
{
    private int $userId;
    private int $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $limit)
    {
        $this->userId = $userId;
        $this->limit  = $limit;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function handle()
    {
        return UserDeliveryAddress::query()
            ->where('user_id', $this->userId)
            ->cursorPaginate($this->limit);
    }
}
