<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\Thread;
use Illuminate\Support\Arr;
use Lucid\Units\Job;
use App\Models\User;

class GetTokenFcmJob extends Job
{
    private string $threadFuid;
    private User $user;

    /**
     * GetTokenFcmJob constructor.
     * @param string $threadFuid
     * @param User $user
     */
    public function __construct(string $threadFuid, User $user)
    {
        $this->threadFuid = $threadFuid;
        $this->user       = $user;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {
        $thread = Thread::query()->find($this->threadFuid)->toArray();

        $userReceiveId = Arr::get($thread, 'participants.buyer_fuid');
        if ($this->user->firebase_uid == Arr::get($thread, 'participants.buyer_fuid')) {
            $userReceiveId = Arr::get($thread, 'participants.seller_fuid');
        }

        $userReceive = User::query()->where('firebase_uid', $userReceiveId)->first();

        return $userReceive->token_fcm;
    }
}
