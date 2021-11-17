<?php

namespace App\Domains\Chatting\Jobs\Message;

use App\Enum\MessageType;
use App\Models\Firestore\Message;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Job;

class CreateSystemCancelPaymentMessageJob extends Job
{
    private string     $threadFuid;
    private string     $text;

    /**
     * CreateSystemCancelPaymentMessageJob constructor.
     * @param string $threadFuid
     * @param string $text
     */
    public function __construct(string $threadFuid, string $text)
    {
        $this->threadFuid = $threadFuid;
        $this->text       = $text;
    }

    /**
     * Execute the job.
     *
     * @return Message
     */
    public function handle(): Message
    {
        $attributes = [
            'uuid'        => null,
            'type'        => MessageType::SYSTEM_CANCEL_PAYMENT,
            'text'        => $this->text,
            'attachment'  => null,
            'sender'      => [
                'fuid'      => '',
                'name'      => '',
                'nickname'  => '',
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
