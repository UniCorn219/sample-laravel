<?php

namespace App\Services\Chatting\Operations;

use App\Enum\MessageType;
use App\Lib\Firestore\Model;
use App\Models\Firestore\Message;
use App\Models\User;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Operation;

class CreatePayCoinMsgOperation extends Operation
{
    private string $threadFuid;
    private User   $sender;
    private string $text;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(string $text, User $sender, string $threadFuid)
    {
        $this->text       = $text;
        $this->sender     = $sender;
        $this->threadFuid = $threadFuid;
    }

    /**
     * Execute the operation.
     *
     * @return Model
     */
    public function handle()
    {
        $attributes = [
            'uuid'        => null,
            'type'        => MessageType::PAYCOIN,
            'text'        => $this->text,
            'attachment'  => null,
            'sender'      => [
                'fuid'     => $this->sender->firebase_uid,
                'name'     => $this->sender->name,
                'nickname' => $this->sender->nickname,
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
