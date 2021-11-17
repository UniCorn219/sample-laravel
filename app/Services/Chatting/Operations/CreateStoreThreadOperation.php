<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\CreateStoreThreadJob;
use App\Domains\Chatting\Jobs\FindThreadByKeyJob;
use App\Domains\Chatting\Jobs\GetLocalInfoJob;
use App\Domains\Chatting\Jobs\Thread\CreateThreadJob;
use App\Domains\Chatting\Jobs\Thread\CreateUserThreadJob;
use App\Domains\Chatting\Jobs\Thread\GetThreadInfoJob;
use App\Domains\Chatting\Jobs\UpdateUserThreadJob;
use App\Helpers\Common;
use App\Models\Firestore\UserThread;
use Lucid\Units\Operation;

class CreateStoreThreadOperation extends Operation
{
    private string $userFuid;

    private string $storeFuid;

    private int|null $localInfoId;

    private string $storeOwnerFuid;

    private int $storeId;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(string $userFuid, string $storeFuid, int|null $localInfoId, string $storeOwnerFuid, int $storeId)
    {
        $this->userFuid       = $userFuid;
        $this->storeFuid      = $storeFuid;
        $this->localInfoId    = $localInfoId;
        $this->storeOwnerFuid = $storeOwnerFuid;
        $this->storeId        = $storeId;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $key    = $this->generateKey();
        $thread = $this->findThreadByKey($key);

        if (!is_null($thread)) {
            $userThread = UserThread::query()
                                    ->where('thread_fuid', $thread->id)
                                    ->where('user_fuid', $this->userFuid)
                                    ->first();

            $this->run(UpdateUserThreadJob::class, [
                'values' => [
                    'is_deleted' => false,
                ],
                'docId'  => $userThread->id,
            ]);
            return $thread->toArray();
        }

        $localInfo = is_null($this->localInfoId) ? null : $this->run(GetLocalInfoJob::class, [
            'localInfoId' => $this->localInfoId,
            'storeId'     => $this->storeId,
        ]);

        $threadFuid = $this->run(CreateThreadJob::class, [
            'product'   => $localInfo,
            'userFuid'  => $this->userFuid,
            'storeFuid' => $this->storeFuid,
            'key'       => $key,
        ]);

        $this->run(CreateUserThreadJob::class, [
            'userFuid'       => $this->userFuid,
            'threadFuid'     => $threadFuid,
            'otherStoreFuid' => $this->storeFuid,
            'storeOwnerFuid' => $this->storeOwnerFuid,
        ]);

        $this->run(CreateStoreThreadJob::class, [
            'otherUserFuid' => $this->userFuid,
            'threadFuid'    => $threadFuid,
            'storeFuid'     => $this->storeFuid,
        ]);

        return $this->run(GetThreadInfoJob::class, ['threadFuid' => $threadFuid]);
    }

    private function generateKey(): string
    {
        return Common::generateThreadKey([
            $this->userFuid,
            $this->storeFuid,
        ], $this->localInfoId);
    }

    private function findThreadByKey($key)
    {
        return $this->run(FindThreadByKeyJob::class, ['key' => $key]);
    }
}
