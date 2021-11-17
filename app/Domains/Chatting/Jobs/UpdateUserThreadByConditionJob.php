<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\Thread;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Lucid\Units\Job;

class UpdateUserThreadByConditionJob extends Job
{
    private string $userFuid;
    private string $targetUserFuid;
    private array  $values;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $userFuid, string $targetUserFuid, array $values)
    {
        $this->userFuid       = $userFuid;
        $this->targetUserFuid = $targetUserFuid;
        $this->values         = $values;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $threads = Thread::query()
                         ->where('buyer_fuid', $this->targetUserFuid)
                         ->where('seller_fuid', $this->userFuid)
                         ->get();

        // make sure all thread between two user must be get.
        $reserveThreads = Thread::query()
            ->where('seller_fuid', $this->targetUserFuid)
            ->where('buyer_fuid', $this->userFuid)
            ->get();

        $threads = $threads->merge($reserveThreads);

        $database = Firebase::firestore()->database();
        $batch    = $database->batch();

        foreach ($threads as $thread) {
            $ref = Thread::query()->getDocumentReference($thread->id);
            $batch->update($ref, $this->values);
        }

        if (count($threads)) {
            $batch->commit();
        }
    }
}
