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

class UpdateStoreLatestMessageOperation extends QueueableOperation
{
    private string $threadFuid;

    private string $storeFuid;

    private string $lastMessageSender;

    private string $lastMessageReceiver;

    private Message $result;

    /**
     * UpdateStoreLatestMessageOperation constructor.
     * @param string $threadFuid
     * @param string $storeFuid
     * @param string $lastMessageSender
     * @param string $lastMessageReceiver
     * @param Message $result
     */
    public function __construct(string $threadFuid, string $storeFuid, string $lastMessageSender, string $lastMessageReceiver, Message $result)
    {
        $this->threadFuid          = $threadFuid;
        $this->storeFuid           = $storeFuid;
        $this->lastMessageSender   = $lastMessageSender;
        $this->lastMessageReceiver = $lastMessageReceiver;
        $this->result              = $result;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $storeThread = $this->run(GetStoreThreadJob::class, [
            'threadFuid' => $this->threadFuid,
            'storeFuid'  => $this->storeFuid,
        ]);

        $lastMessageSender = array_merge($this->result->toArray(), [
            'message'     => $this->lastMessageSender,
            'sender_fuid' => $this->storeFuid,
            'time'        => new Timestamp(new DateTime()),
        ]);

        $this->run(UpdateStoreThreadJob::class, [
            'docId'  => $storeThread->id,
            'values' => [
                'last_message' => $lastMessageSender,
                'is_deleted'   => false,
            ]
        ]);

        $otherUserThread = $this->run(GetUserThreadJob::class, [
            'userFuid'    => $storeThread->other_user_fuid,
            'threadFuid'  => $this->threadFuid,
            'withDeleted' => true,
        ]);

        $lastMessageReceiver = array_merge($this->result->toArray(), [
            'message'     => $this->lastMessageReceiver,
            'sender_fuid' => $this->storeFuid,
            'time'        => new Timestamp(new DateTime()),
        ]);

        $this->run(UpdateUserThreadJob::class, [
            'docId'  => $otherUserThread->id,
            'values' => [
                'last_message' => $lastMessageReceiver,
                'is_deleted'   => false,
            ]
        ]);
    }
}
