<?php

namespace App\Domains\User\Jobs;

use App\Enum\UserActionableType;
use App\Models\AbstractModel;
use App\Models\Store;
use App\Models\User;
use App\Models\UserActionable;
use Lucid\Units\Job;

class GetListFollowingStoresJob extends Job
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
        $storeFollows = UserActionable::query()
            ->where('user_id', $this->userId)
            ->where('action_type', UserActionableType::ACTION_USER_FOLLOW)
            ->where('target_type', UserActionableType::ENTITY_STORE)
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->pluck('target_id')
            ->toArray();

        return Store::query()
            ->whereIn('id', $storeFollows)
            ->whereNull('deleted_at')
            ->cursorPaginate($this->limit);
    }
}
