<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\Message\CreateImageMessageJob;
use App\Domains\Chatting\Jobs\UploadFileS3Job;
use App\Models\Store;
use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Lucid\Units\Operation;

class CreateImageOperation extends Operation
{
    private User|Store   $sender;
    private string       $threadFuid;
    private UploadedFile $image;
    private string       $id;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(User|Store $sender, string $threadFuid, UploadedFile $image, string $id)
    {
        $this->sender     = $sender;
        $this->threadFuid = $threadFuid;
        $this->image      = $image;
        $this->id         = $id;
    }

    /**
     * Execute the operation.
     *
     * @throws Exception
     */
    public function handle()
    {
        $attachment = $this->run(UploadFileS3Job::class, [
            'image'      => $this->image,
            'threadFuid' => $this->threadFuid,
        ]);

        return $this->run(CreateImageMessageJob::class, [
            'sender'     => $this->sender,
            'threadFuid' => $this->threadFuid,
            'attachment' => $attachment,
            'id'         => $this->id,
        ]);
    }
}
