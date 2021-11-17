<?php

namespace App\Domains\Chatting\Jobs;

use App\Exceptions\ResourceNotFoundException;
use App\Lib\Firestore\Model;
use App\Models\Firestore\StoreThread;
use Lucid\Units\Job;
use Throwable;

class GetStoreThreadJob extends Job
{
    private string $threadFuid;
    private string $storeFuid;
    private bool $withDeleted;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $threadFuid, string $storeFuid, bool $withDeleted = false)
    {
        $this->threadFuid = $threadFuid;
        $this->storeFuid  = $storeFuid;
        $this->withDeleted = $withDeleted;
    }

    /**
     * Execute the job.
     *
     * @return Model
     * @throws Throwable
     */
    public function handle(): Model
    {
        $query = StoreThread::query()
                                 ->where('store_fuid', $this->storeFuid)
                                 ->where('thread_fuid', $this->threadFuid);

        if (!$this->withDeleted) {
            $query = $query->where('is_deleted', false);
        }

        $storeThread = $query->first();
        throw_if(is_null($storeThread), ResourceNotFoundException::class);

        return $storeThread;
    }
}
