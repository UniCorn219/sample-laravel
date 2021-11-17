<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\Message\CreateTextMessageJob;
use App\Models\Firestore\Message;
use App\Models\Store;
use Lucid\Units\Operation;
use App\Models\User;

class CreateTextMessageOperation extends Operation
{
    private User|Store $sender;
    private string     $threadFuid;
    private string     $text;
    private string     $id;

    /**
     * Create a new operation instance.
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
     * Execute the operation.
     *
     * @return Message
     */
    public function handle()
    {
        return $this->run(CreateTextMessageJob::class, [
            'sender'     => $this->sender,
            'threadFuid' => $this->threadFuid,
            'text'       => $this->text,
            'id'         => $this->id,
        ]);
    }
}
