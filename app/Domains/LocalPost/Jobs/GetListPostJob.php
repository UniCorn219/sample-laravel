<?php

namespace App\Domains\LocalPost\Jobs;

use App\Criteria\LocalPostCriteria;
use App\Enum\UserHidingType;
use App\Models\LocalPost;
use App\Models\LocalPostBlocking;
use App\Models\UserBlocking;
use App\Models\UserHiding;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\CursorPaginator;
use Lucid\Units\Job;

class GetListPostJob extends Job
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
     */
    public function handle(): Paginator|CursorPaginator
    {
        $localPostBlockedIds = LocalPostBlocking::where('user_id', $this->param['currentUserId'])
            ->select('localpost_id')
            ->get()->pluck('localpost_id')
            ->toArray();

        if (count($localPostBlockedIds)) {
            $this->param['localpost_blocked_ids'] = $localPostBlockedIds;
        }

        $hideLocalPostByAuthor = UserHiding::query()->where([
            'user_id' => $this->param['currentUserId'],
            'type' => UserHidingType::LOCAL_POST
        ])->get()->pluck('user_target_id')->toArray();

        $userBlockingIds = UserBlocking::query()
            ->where(['user_id' => $this->param['currentUserId']])
            ->pluck('user_target_id')
            ->toArray();

        if (count($hideLocalPostByAuthor)) {
            $this->param['hide_author_id'] = $hideLocalPostByAuthor;
        }

        if (count($userBlockingIds)) {
            if (isset($this->param['hide_author_id'])) {
                $this->param['hide_author_id'] = array_merge($userBlockingIds, $this->param['hide_author_id']);
            } else {
                $this->param['hide_author_id'] = $userBlockingIds;
            }
        }

        $query = LocalPost::query();
        (new LocalPostCriteria($this->param))->apply($query);
        $query->with(['owner.address', 'emdArea.siggArea.sidoArea', 'images', 'category']);

        $limit = $this->param['limit'] ?? 10;
        $limit = min(50, $limit);

        return $query->orderByDesc('id')->cursorPaginate($limit);
    }
}
