<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\StoreProfile;
use App\Models\Firestore\StoreThread;
use App\Models\Firestore\Thread;
use App\Models\Firestore\User;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Job;
use DateTime;

class CreateStoreThreadJob extends Job
{
    private string $otherUserFuid;
    private string $threadFuid;
    private string $storeFuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $otherUserFuid, string $threadFuid, string $storeFuid)
    {
        $this->otherUserFuid = $otherUserFuid;
        $this->threadFuid    = $threadFuid;
        $this->storeFuid     = $storeFuid;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {
        return StoreThread::query()->insertGetId([
            'store_fuid'      => $this->storeFuid,
            'store'           => StoreProfile::query()->getDocumentReference($this->storeFuid),

            'other_user_fuid' => $this->otherUserFuid,
            'other_user'      => User::query()->getDocumentReference($this->otherUserFuid),
            'notify_user_fuid' => $this->otherUserFuid,

            'thread_fuid'     => $this->threadFuid,
            'thread'          => Thread::query()->getDocumentReference($this->threadFuid),

            'settings'        => [
                'can_notify' => true,
            ],
            'read_at'         => null,
            'unread_count'    => 0,
            'created_at'      => new Timestamp(new DateTime()),
            'updated_at'      => new Timestamp(new DateTime()),
            'is_deleted'      => false,
            'deleted_at'      => null,
            'last_message' => [
                'message'     => '',
                'sender_fuid' => '',
                'time'        => '',
            ],
        ]);
    }
}
