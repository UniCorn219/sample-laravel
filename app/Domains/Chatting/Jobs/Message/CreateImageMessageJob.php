<?php

namespace App\Domains\Chatting\Jobs\Message;

use App\Enum\MessageType;
use App\Models\Firestore\Message;
use App\Models\Store;
use App\Models\User;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Job;

class CreateImageMessageJob extends Job
{
    private User|Store $sender;
    private string     $threadFuid;
    private string     $attachment;
    private string     $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User|Store $sender, string $threadFuid, string $attachment, string $id)
    {
        $this->sender     = $sender;
        $this->threadFuid = $threadFuid;
        $this->attachment = $attachment;
        $this->id         = $id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $attributes = [
            'uuid'        => $this->id,
            'type'        => MessageType::IMAGE,
            'text'        => null,
            'attachment'  => $this->attachment,
            'sender'      => [
                'fuid'      => $this->sender->firebase_uid,
                'name'      => $this->sender->name,
                'nickname'  => $this->sender->nickname,
            ],
            'address'     => [
                'lat'         => null,
                'long'        => null,
                'name'        => null,
                'description' => null,
            ],
            'reservation' => [
                'time'   => null,
                'status' => null,
            ],
            'thread_fuid' => $this->threadFuid,
            'is_read'     => false,
            'created_at'  => new Timestamp(new DateTime()),
            'updated_at'  => new Timestamp(new DateTime()),
        ];

        $messageId = Message::query()->insertGetId($attributes);

        return Message::query()->newModelInstance(
            array_merge(
                $attributes,
                ['id' => $messageId],
            )
        );
    }
}
