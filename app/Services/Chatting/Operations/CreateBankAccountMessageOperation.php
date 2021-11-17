<?php

namespace App\Services\Chatting\Operations;

use App\Enum\MessageType;
use App\Models\Firestore\Message;
use App\Models\Store;
use App\Models\User;
use App\Models\UserBankAccount;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Operation;
use DateTime;

class CreateBankAccountMessageOperation extends Operation
{
    private User|Store      $sender;
    private string          $threadFuid;
    private string          $text;
    private string          $id;
    private UserBankAccount $bankAccount;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(User|Store $sender, string $threadFuid, string $text, string $id, UserBankAccount $bankAccount)
    {
        $this->sender      = $sender;
        $this->threadFuid  = $threadFuid;
        $this->text        = $text;
        $this->id          = $id;
        $this->bankAccount = $bankAccount;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $attributes = [
            'uuid'            => $this->id,
            'type'            => MessageType::BANK_ACCOUNT,
            'text'            => $this->text,
            'attachment'      => null,
            'sender'          => [
                'fuid'     => $this->sender->firebase_uid,
                'name'     => $this->sender->name,
                'nickname' => $this->sender->nickname,
            ],
            'address'         => [
                'lat'         => null,
                'long'        => null,
                'name'        => null,
                'description' => null,
            ],
            'reservation'     => [
                'time'   => null,
                'status' => null,
            ],
            'thread_fuid'     => $this->threadFuid,
            'is_read'         => false,
            'created_at'      => new Timestamp(new DateTime()),
            'updated_at'      => new Timestamp(new DateTime()),
            'bank_account'    => $this->bankAccount->toArray(),
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
