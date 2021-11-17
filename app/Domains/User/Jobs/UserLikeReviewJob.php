<?php

namespace App\Domains\User\Jobs;

use App\Enum\UserReviewableType;
use App\Models\Store;
use App\Models\UserLikeReview;
use App\Models\UserReviewable;
use Exception;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;
use Throwable;

class UserLikeReviewJob extends Job
{
    private array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return null|array
     * @throws Throwable
     */
    public function handle(): ?array
    {
        $data = $this->data;
        $reviewId = $data['review_id'];
        $data['user_reviewable_id'] = $reviewId;
        $reviewData = UserReviewable::findOrFail($reviewId);
        $userLiked = UserLikeReview::where([
            'user_reviewable_id' => $reviewId,
            'user_id' => $data['user_id']
        ])->first();

        DB::beginTransaction();
        try {
            if ($userLiked) {
                $userLiked->delete();
                $like = -1;
            } else {
                UserLikeReview::create($data);
                $like = 1;
            }

            if ((int) $reviewData->review_type === UserReviewableType::STORE) {
                $storeId = $reviewData->target_id;
                $store = Store::whereId($storeId)->useWritePdo()->lockForUpdate()->first();
                $store->total_like += $like;
                $store->timestamps = false;
                $store->save();
            }
            $reviewData->total_like += $like;
            $reviewData->timestamps = false;
            $reviewData->save();

            DB::commit();
            return $userLiked ? ['unlike' => true] : ['like' => true];
        } catch (Throwable $e) {
            DB::rollBack();
            throw new Exception($e);
        }
    }
}
