<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\Thread\GetThreadInfoJob;
use App\Models\User;
use Illuminate\Support\Arr;
use Lucid\Units\Operation;

class IsThreadBelongToUserOperation extends Operation
{
    private string $operatorFuid;
    private string $threadFuid;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(string $operatorFuid, string $threadFuid)
    {
        $this->operatorFuid = $operatorFuid;
        $this->threadFuid   = $threadFuid;
    }

    /**
     * Execute the operation.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $thread = $this->run(GetThreadInfoJob::class, [
            'threadFuid' => $this->threadFuid,
        ]);

        $participants   = Arr::get($thread, 'participants');
        $participantIds = array_map(function ($value) {
            return $value['id'];
        }, array_values($participants));

        return in_array($this->operatorFuid, $participantIds);
    }
}
