<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\UpdateThreadJob;
use Lucid\Units\Operation;

class UnblockThreadOperation extends Operation
{
    private string $threadFuid;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(string $threadFuid)
    {
        $this->threadFuid = $threadFuid;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        return $this->run(UpdateThreadJob::class, [
            'values' => [
                'block_by' => null,
            ],
            'docId' => $this->threadFuid,
        ]);
    }
}
