<?php

namespace App\Domains\User\Jobs;

use App\Models\LocalPost;
use App\Models\LocalPostBlocking;
use App\Models\UserHiding;
use Lucid\Units\Job;

class UnBlockUserFromAllPostJob extends Job
{
    private int $userId;
    private int $userUnblockId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $userUnblockId)
    {
        $this->userId = $userId;
        $this->userUnblockId = $userUnblockId;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $localPostBlockingUserId = LocalPost::query()
            ->where('author_id', $this->userId)
            ->join('localpost_blocking', 'localpost.id', '=', 'localpost_blocking.localpost_id')
            ->where('localpost_blocking.user_id', $this->userUnblockId)
            ->select('localpost_blocking.id')
            ->get()
            ->pluck('id');

        try {
            UserHiding::where([
                'user_id' => $this->userId,
                'user_target_id' => $this->userUnblockId,
            ])->delete();

            LocalPostBlocking::whereIn('id', $localPostBlockingUserId)->delete();
            return true;
        } catch (\Exception) {
            return false;
        }
    }
}
