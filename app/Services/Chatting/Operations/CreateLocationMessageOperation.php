<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\GetMessageInstanceJob;
use App\Enum\MessageType;
use App\Models\Firestore\Message;
use App\Models\Store;
use App\Models\User;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Operation;

class CreateLocationMessageOperation extends Operation
{
    private User|Store $sender;
    private string     $threadFuid;
    private array      $location;
    private string     $id;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(User|Store $sender, string $threadFuid, array $location, string $id)
    {
        $this->sender     = $sender;
        $this->threadFuid = $threadFuid;
        $this->location   = $location;
        $this->id         = $id;
    }

    /**
     * Execute the operation.
     */
    public function handle()
    {
        $attributes = [
            'uuid'        => $this->id,
            'type'        => MessageType::LOCATION,
            'text'        => null,
            'attachment'  => null,
            'sender'      => [
                'fuid'      => $this->sender->firebase_uid,
                'name'      => $this->sender->name,
                'nickname'  => $this->sender->nickname,
            ],
            'address'     => $this->location,
            'reservation' => [
                'time'   => null,
                'status' => null,
            ],
            'thread_fuid' => $this->threadFuid,
            'is_read'     => false,
            'created_at'  => new Timestamp(new DateTime()),
            'updated_at'  => new Timestamp(new DateTime()),
        ];

        $messageId = Message::query()->insertGetId($attributes, $this->id);

        return $this->run(GetMessageInstanceJob::class, [
            'attributes' => $attributes,
            'messageId'  => $messageId,
        ]);
    }
}
