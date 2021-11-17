<?php

namespace App\Domains\Product\Jobs;

use App\Enum\UserHidingType;
use App\Models\UserBlocking;
use App\Models\UserHiding;
use Lucid\Units\Job;

class GetUserBlockAndHideProductByAuthJob extends Job
{
    private int $authId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $authId)
    {
        $this->authId = $authId;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle(): array
    {
        $result = [];

        $hideLocalPostByAuthor = UserHiding::query()->where([
            'user_id' => $this->authId,
            'type' => UserHidingType::PRODUCT
        ])->get()->pluck('user_target_id')->toArray();

        $userBlockingIds = UserBlocking::query()
            ->where(['user_id' => $this->authId])
            ->pluck('user_target_id')
            ->toArray();

        if (count($hideLocalPostByAuthor)) {
            $result = $hideLocalPostByAuthor;
        }

        if (count($userBlockingIds)) {
            if (isset($query['hide_author_id'])) {
                $result = array_merge($userBlockingIds, $result);
            } else {
                $result = $userBlockingIds;
            }
        }

        return $result;
    }
}
