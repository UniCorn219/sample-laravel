<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\Thread\GetThreadInfoJob;
use App\Domains\Chatting\Jobs\Thread\GetUserThreadJob;
use App\Domains\Chatting\Jobs\UpdateUserThreadJob;
use App\Domains\Product\Jobs\DeleteProductThreadJob;
use App\Domains\Product\Jobs\RecountProductTotalChatJob;
use App\Models\User;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Operation;
use DateTime;
use Exception;

class DeleteThreadOperation extends Operation
{
    private User   $user;
    private string $threadFuid;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(User $user, string $threadFuid)
    {
        $this->threadFuid = $threadFuid;
        $this->user       = $user;
    }

    /**
     * Execute the operation.
     *
     * @return bool
     */
    public function handle()
    {
        $userThread = $this->run(GetUserThreadJob::class, [
            'threadFuid' => $this->threadFuid,
            'userFuid'   => $this->user->firebase_uid,
        ]);

        // TODO: Run two query below in one batch
        $this->run(UpdateUserThreadJob::class, [
            'values' => [
                'is_deleted' => true,
                'deleted_at' => new Timestamp(new DateTime()),
            ],
            'docId'      => $userThread->id,
        ]);

        $productId = $this->run(DeleteProductThreadJob::class, [
            'threadFuid' => $this->threadFuid,
        ]);
        if ($productId) {
            $this->run(RecountProductTotalChatJob::class, ['id' => $productId]);
        }

        return true;
    }
}
