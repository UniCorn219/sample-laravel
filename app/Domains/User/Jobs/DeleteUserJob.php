<?php

namespace App\Domains\User\Jobs;

use App\Models\LocalInfo;
use App\Models\LocalInfoComment;
use App\Models\LocalInfoLike;
use App\Models\LocalInfoReport;
use App\Models\LocalPost;
use App\Models\LocalPostBlocking;
use App\Models\LocalPostComment;
use App\Models\LocalPostLike;
use App\Models\LocalPostReport;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\User;
use App\Models\UserActionable;
use App\Models\UserBlocking;
use App\Models\UserChats;
use App\Models\UserHiding;
use App\Models\UserReviewable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Lucid\Units\Job;
use Throwable;

class DeleteUserJob extends Job
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
     * Execute the job.
     *
     * @return bool
     * @throws Throwable
     */
    public function handle(): bool
    {
        $userId = $this->id;
        DB::beginTransaction();
        try {
            ProductLike::where('user_id', $userId)->delete();
            LocalInfo::where('author_id', $userId)->delete();
            LocalInfoComment::where('user_id', $userId)->delete();
            LocalInfoLike::where('user_id', $userId)->delete();
            LocalInfoReport::where('user_id', $userId)->delete();
            LocalPostComment::where('user_id', $userId)->delete();
            LocalPostLike::where('user_id', $userId)->delete();
            LocalPostReport::where('user_id', $userId)->delete();
            LocalPost::where('author_id', $userId)->delete();
            Product::where('author_id', $userId)->delete();
            ProductLike::where('user_id', $userId)->delete();
            LocalPostBlocking::where('user_id', $userId)->delete();
            UserChats::where('user_id', $userId)->delete();
            UserBlocking::where('user_id', $userId)->delete();
            UserHiding::where('user_id', $userId)->delete();
            UserActionable::where('user_id', $userId)->delete();
            UserReviewable::where('user_id', $userId)->delete();
            User::find($userId)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }
}
