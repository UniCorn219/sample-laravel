<?php

namespace App\Domains\Chatting\Jobs\Message;

use App\Enum\MessageType;
use App\Models\Firestore\Message;
use App\Models\Store;
use App\Models\User;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Job;

class CreateTextMessageJob extends Job
{
    private User|Store $sender;
    private string     $threadFuid;
    private string     $text;
    private string     $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User|Store $sender, string $threadFuid, string $text, string $id)
    {
        $this->sender     = $sender;
        $this->threadFuid = $threadFuid;
        $this->text       = $text;
        $this->id         = $id;
    }

    /**
     * Execute the job.
     *
     * @return Message
     */
    public function handle(): Message
    {
        $attributes = [
            'uuid'        => $this->id,
            'type'        => MessageType::TEXT,
            'text'        => $this->text,
            'attachment'  => null,
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
