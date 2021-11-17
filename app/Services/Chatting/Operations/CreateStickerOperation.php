<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\CreateMessageJob;
use App\Domains\Chatting\Jobs\GetMessageInstanceJob;
use App\Enum\MessageType;
use App\Models\Store;
use App\Models\User;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Operation;
use DateTime;

class CreateStickerOperation extends Operation
{
    private User|Store $sender;
    private string     $threadFuid;
    private            $sticker;
    private string     $id;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(User|Store $sender, string $threadFuid, $sticker, string $id)
    {
        $this->sender     = $sender;
        $this->threadFuid = $threadFuid;
        $this->sticker    = $sticker;
        $this->id         = $id;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $attributes = [
            'uuid'        => $this->id,
            'type'        => MessageType::STICKER,
            'text'        => null,
            'attachment'  => null,
            'sender'      => [
                'fuid'      => $this->sender->firebase_uid,
                'name'      => $this->sender->name,
                'nickname'  => $this->sender->nickname,
            ],
            'address'     => null,
            'sticker'     => $this->sticker,
            'reservation' => [
                'time'   => null,
                'status' => null,
            ],
            'thread_fuid' => $this->threadFuid,
            'is_read'     => false,
            'created_at'  => new Timestamp(new DateTime()),
            'updated_at'  => new Timestamp(new DateTime()),
        ];

        $messageId = $this->run(CreateMessageJob::class, [
            'attributes' => $attributes,
        ]);

        return $this->run(GetMessageInstanceJob::class, [
            'attributes' => $attributes,
            'messageId'  => $messageId,
        ]);
    }
}
