<?php

namespace App\Domains\UserReviewable\Jobs;

use App\Models\UserReviewable;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;
use Exception;
use Throwable;

class CreateUserReplyReviewJob extends Job
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
     * @return UserReviewable
     * @throws Throwable
     */
    public function handle(): UserReviewable
    {
        $id = $this->data['reply_id'];
        $userReviewDetail = UserReviewable::findOrFail($id);

        $type = $userReviewDetail->review_type;
        $targetId = $userReviewDetail->target_id;
        $payload = array_merge($this->data, [
            'review_type' => $type,
            'target_id' => $targetId,
        ]);

        DB::beginTransaction();
        try {
            $review = UserReviewable::whereId($id)->useWritePdo()->first();
            $review->total_reply += 1;
            $review->save();
            $result = UserReviewable::create($payload);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
