<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\UpdateThreadJob;
use App\Lib\Firestore\Model;
use Lucid\Units\Operation;

class BlockThreadOperation extends Operation
{
    private string $threadFuid;
    private string $userFuid;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(string $threadFuid, string $userFuid)
    {
        $this->threadFuid = $threadFuid;
        $this->userFuid   = $userFuid;
    }

    /**
     * Execute the operation.
     *
     * @return Model
     */
    public function handle()
    {
        return $this->run(UpdateThreadJob::class, [
            'values' => [
                'block_by' => $this->userFuid,
            ],
            'docId' => $this->threadFuid,
        ]);
    }
}
