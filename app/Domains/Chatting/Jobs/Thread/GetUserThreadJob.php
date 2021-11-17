<?php

namespace App\Domains\Chatting\Jobs\Thread;

use App\Exceptions\ResourceNotFoundException;
use App\Lib\Firestore\Model;
use App\Models\Firestore\UserThread;
use Lucid\Units\Job;
use Throwable;

class GetUserThreadJob extends Job
{
    private string $threadFuid;
    private string $userFuid;
    private bool   $withDeleted;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $threadFuid, string $userFuid, bool $withDeleted = false)
    {
        $this->threadFuid = $threadFuid;
        $this->userFuid   = $userFuid;
        $this->withDeleted  = $withDeleted;
    }

    /**
     * Execute the job.
     *
     * @return Model
     * @throws Throwable
     */
    public function handle(): Model
    {
        $query = UserThread::query()
                                ->where('user_fuid', $this->userFuid)
                                ->where('thread_fuid', $this->threadFuid);

        if (!$this->withDeleted) {
            $query = $query->where('is_deleted', false);
        }

        $userThread = $query->first();

        throw_if(is_null($userThread), ResourceNotFoundException::class);

        return $userThread;
    }
}
