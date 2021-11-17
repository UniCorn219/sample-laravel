<?php

namespace App\Services\Chatting\Features;

use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\ThreadDoesNotBlockByUserException;
use App\Models\Firestore\Thread;
use App\Models\Store;
use App\Services\BaseFeatures;
use App\Services\Chatting\Operations\UnblockThreadOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnblockUserThreadFeature extends BaseFeatures
{
    private string $threadFuid;

    public function __construct(string $threadFuid)
    {
        $this->threadFuid = $threadFuid;
    }

    public function handle(Request $request)
    {
        $storeId = $request->get('store_id', null);
        $fuid = $this->getOperatorFuid($storeId);

        $thread = $this->getThread();

        $this->canUnblock($thread, $fuid);
        $result = $this->unblock();

        return $this->responseOk([
            'data' => $result,
        ]);
    }

    /**
     * Get which entity's firebase_uid (store or user)
     * @param $storeId
     * @return string
     */
    private function getOperatorFuid($storeId): string
    {
        if (is_null($storeId)) {
            return Auth::user()->firebase_uid;
        }

        $store = Store::query()->where([
            'owner_id' => Auth::user()->id,
            'id'       => $storeId,
        ])->firstOrFail();

        return $store->firebase_uid;
    }

    private function getThread()
    {
        $thread = Thread::query()->find($this->threadFuid);

        throw_if(empty($thread), ResourceNotFoundException::class);

        return $thread;
    }

    private function canUnblock(Thread $thread, string $fuid)
    {
        throw_if($thread->block_by !== $fuid, ThreadDoesNotBlockByUserException::class);
    }

    private function unblock()
    {
        return $this->run(UnblockThreadOperation::class, [
            'threadFuid' => $this->threadFuid,
        ]);
    }
}
