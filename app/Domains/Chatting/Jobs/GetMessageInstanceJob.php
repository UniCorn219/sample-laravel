<?php

namespace App\Domains\Chatting\Jobs;

use App\Lib\Firestore\Model;
use App\Models\Firestore\Message;
use Lucid\Units\Job;

class GetMessageInstanceJob extends Job
{
    private array $attributes;
    private string $messageId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $attributes, string $messageId)
    {
        $this->attributes = $attributes;
        $this->messageId = $messageId;
    }

    /**
     * @return Message
     */
    public function handle(): Message
    {
        return Message::query()->newModelInstance(
            array_merge(
                $this->attributes,
                ['id' => $this->messageId],
            )
        );
    }
}
