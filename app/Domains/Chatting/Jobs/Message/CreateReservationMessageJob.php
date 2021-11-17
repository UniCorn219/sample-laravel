<?php

namespace App\Domains\Chatting\Jobs\Message;

use App\Enum\MessageType;
use App\Models\Firestore\Message;
use App\Models\User;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Job;

class CreateReservationMessageJob extends Job
{
    private User          $user;
    private string        $threadFuid;
    private DateTime|null $datetime;
    private DateTime|null $timeRemind;
    private string        $reservationStatus;
    private int|null      $reservationId;
    private string        $text;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        string $threadFuid,
        string $reservationStatus,
        string $text,
        DateTime|null $datetime = null,
        DateTime|null $timeRemind = null,
        int $reservationId = null
    )
    {
        $this->user              = $user;
        $this->threadFuid        = $threadFuid;
        $this->datetime          = $datetime;
        $this->timeRemind        = $timeRemind;
        $this->reservationStatus = $reservationStatus;
        $this->reservationId     = $reservationId;
        $this->text              = $text;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle(): Message
    {
        $attributes = [
            'type'        => MessageType::RESERVATION,
            'text'        => $this->text,
            'attachment'  => null,
            'sender'      => [
                'fuid'     => $this->user->firebase_uid,
                'name'     => $this->user->name,
                'nickname' => $this->user->nickname,
            ],
            'address'     => [
                'lat'         => null,
                'long'        => null,
                'name'        => null,
                'description' => null,
            ],
            'reservation' => [
                'id'          => $this->reservationId,
                'time'        => is_null($this->datetime) ? null : new Timestamp($this->datetime),
                'time_remind' => $this->timeRemind,
                'status'      => $this->reservationStatus,
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
