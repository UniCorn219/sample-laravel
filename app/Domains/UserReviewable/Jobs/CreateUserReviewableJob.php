<?php

namespace App\Domains\UserReviewable\Jobs;

use App\Enum\UserReviewableType;
use App\Models\Store;
use App\Models\User;
use App\Models\UserReviewable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;
use Throwable;

class CreateUserReviewableJob extends Job
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
     * @return Model|UserReviewable
     * @throws Throwable
     */
    public function handle(): Model|UserReviewable
    {
        $data = $this->data;
        $this->checkResourceExists($data);

        return UserReviewable::create($data);
    }

    /**
     * @param array $data
     *
     * @throws Throwable
     */
    public function checkResourceExists(array $data)
    {
        $type = (int) $data['review_type'];
        $id = $data['target_id'];

        if ($type === UserReviewableType::USER) {
            User::findOrFail($id);
        } else {
            Store::findOrFail($id);
            DB::transaction(function () use ($id) {
                $store = Store::whereId($id)->useWritePdo()->first();
                $store->total_review += 1;
                $store->timestamps = false;
                $store->save();
            });
        }
    }
}
