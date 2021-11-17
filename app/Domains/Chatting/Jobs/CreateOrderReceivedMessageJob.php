<?php

namespace App\Domains\Chatting\Jobs;

use App\Enum\MessageType;
use App\Models\Firestore\Message;
use App\Models\User;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Job;

class CreateOrderReceivedMessageJob extends Job
{
    private User   $user;
    private string $threadFuid;
    private string $text;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, string $threadFuid, string $text)
    {
        $this->user       = $user;
        $this->threadFuid = $threadFuid;
        $this->text       = $text;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $attributes = [
            'type'        => MessageType::ORDER_RECEIVED,
            'text'        => $this->text,
            'attachment'  => null,
            'sender'      => [
                'fuid'      => $this->user->firebase_uid,
                'name'      => $this->user->name,
                'nickname'  => $this->user->nickname,
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
