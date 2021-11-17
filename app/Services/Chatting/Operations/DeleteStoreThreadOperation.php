<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\GetStoreThreadJob;
use App\Domains\Chatting\Jobs\UpdateStoreThreadJob;
use App\Models\Store;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Operation;

class DeleteStoreThreadOperation extends Operation
{
    private Store  $store;
    private string $threadFuid;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Store $store, string $threadFuid)
    {
        $this->store      = $store;
        $this->threadFuid = $threadFuid;
    }

    /**
     * Execute the operation.
     *
     * @return bool
     */
    public function handle()
    {
        $storeThread = $this->run(GetStoreThreadJob::class, [
            'storeFuid'    => $this->store->firebase_uid,
            'threadFuid'   => $this->threadFuid,
            'with_deleted' => true,
        ]);

        $this->run(UpdateStoreThreadJob::class, [
            'values' => [
                'is_deleted' => true,
                'deleted_at' => new Timestamp(new DateTime()),
            ],
            'docId'      => $storeThread->id,
        ]);

        return true;
    }
}
