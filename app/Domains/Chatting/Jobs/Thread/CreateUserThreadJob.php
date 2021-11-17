<?php

namespace App\Domains\Chatting\Jobs\Thread;

use App\Models\Firestore\StoreProfile;
use App\Models\Firestore\Thread;
use App\Models\Firestore\User;
use App\Models\Firestore\UserThread;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Job;

class CreateUserThreadJob extends Job
{
    private string $userFuid;

    private string $threadFuid;

    private string $otherUserFuid;

    private string $otherStoreFuid;

    private string $storeOwnerFuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $userFuid,
        string $threadFuid,
        string $otherUserFuid = '',
        string $otherStoreFuid = '',
        string $storeOwnerFuid = '',
    ) {
        $this->userFuid      = $userFuid;
        $this->threadFuid    = $threadFuid;
        $this->otherUserFuid = $otherUserFuid;
        $this->otherStoreFuid = $otherStoreFuid;
        $this->storeOwnerFuid = $storeOwnerFuid;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $data = [
            'user_fuid' => $this->userFuid,
            'user'      => User::query()->getDocumentReference($this->userFuid),

            'thread_fuid' => $this->threadFuid,
            'thread'      => Thread::query()->getDocumentReference($this->threadFuid),

            'settings'     => [
                'can_notify'       => true,
            ],
            'read_at'      => null,
            'unread_count' => 0,
            'created_at'   => new Timestamp(new DateTime()),
            'updated_at'   => new Timestamp(new DateTime()),
            'is_deleted'   => false,
            'deleted_at'   => null,
            'last_message' => [
                'message'     => '',
                'sender_fuid' => '',
                'time'        => '',
            ],
        ];

        if ($this->otherUserFuid) {
            $otherUserData = [
                'other_user_fuid' => $this->otherUserFuid,
                'other_user'      => User::query()->getDocumentReference($this->otherUserFuid),
                'notify_user_fuid' => $this->otherUserFuid,
            ];

            $data = array_merge($data, $otherUserData);
        }

        if ($this->otherStoreFuid && $this->storeOwnerFuid) {
            $otherStoreData = [
                'other_store_fuid' => $this->otherStoreFuid,
                'other_store'      => StoreProfile::query()->getDocumentReference($this->otherStoreFuid),
                'notify_user_fuid' => $this->storeOwnerFuid,
            ];

            $data = array_merge($data, $otherStoreData);
        }

        return UserThread::query()->insertGetId($data);
    }
}
