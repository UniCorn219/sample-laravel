<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\GetStoreThreadJob;
use App\Domains\Chatting\Jobs\Thread\GetUserThreadJob;
use App\Domains\Chatting\Jobs\UpdateStoreThreadJob;
use App\Domains\Chatting\Jobs\UpdateUserThreadJob;
use App\Models\Firestore\Message;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\QueueableOperation;

class UpdateLatestMessageOperation extends QueueableOperation
{
    private string $threadFuid;

    private string $userFuid;

    private string $lastMessageSender;

    private string $lastMessageReceiver;

    private Message $result;

    /**
     * UpdateLatestMessageOperation constructor.
     * @param string $threadFuid
     * @param string $userFuid
     * @param string $lastMessageSender
     * @param string $lastMessageReceiver
     * @param Message $result
     */
    public function __construct(string $threadFuid, string $userFuid, string $lastMessageSender, string $lastMessageReceiver, Message $result)
    {
        $this->threadFuid          = $threadFuid;
        $this->userFuid            = $userFuid;
        $this->lastMessageSender   = $lastMessageSender;
        $this->lastMessageReceiver = $lastMessageReceiver;
        $this->result              = $result;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TODO: MUST WRITE IN ONE BATCH TO IMPROVE PERFORMANCE, USING TRANSACTION.
        // https://firebase.google.com/docs/firestore/manage-data/transactions#batched-writes

        $userThread = $this->run(GetUserThreadJob::class, [
            'threadFuid' => $this->threadFuid,
            'userFuid'   => $this->userFuid,
        ]);

        $lastMessageSender = array_merge($this->result->toArray(), [
            'message'     => $this->lastMessageSender,
            'sender_fuid' => $this->userFuid,
            'time'        => new Timestamp(new DateTime()),
        ]);

        $lastMessageReceiver = array_merge($this->result->toArray(), [
            'message'     => $this->lastMessageReceiver,
            'sender_fuid' => $this->userFuid,
            'time'        => new Timestamp(new DateTime()),
        ]);

        $this->run(UpdateUserThreadJob::class, [
            'docId'  => $userThread->id,
            'values' => [
                'last_message' => $lastMessageSender,
                'is_deleted'   => false
            ]
        ]);

        if ($userThread->other_user_fuid) {
            $otherUserThread = $this->run(GetUserThreadJob::class, [
                'userFuid'    => $userThread->other_user_fuid,
                'threadFuid'  => $this->threadFuid,
                'withDeleted' => true,
            ]);

            $this->run(UpdateUserThreadJob::class, [
                'docId'  => $otherUserThread->id,
                'values' => [
                    'last_message' => $lastMessageReceiver,
                    'is_deleted'   => false,
                ]
            ]);
        } else {
            $otherStoreThread = $this->run(GetStoreThreadJob::class, [
                'storeFuid'   => $userThread->other_store_fuid,
                'threadFuid'  => $this->threadFuid,
                'withDeleted' => true,
            ]);

            $this->run(UpdateStoreThreadJob::class, [
                'docId'  => $otherStoreThread->id,
                'values' => [
                    'last_message' => $lastMessageReceiver,
                    'is_deleted'   => false,
                ]
            ]);
        }
    }
}
