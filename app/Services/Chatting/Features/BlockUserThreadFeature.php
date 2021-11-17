<?php

namespace App\Services\Chatting\Features;

use App\Exceptions\ThreadDoesNotBelongToUserException;
use App\Models\Store;
use App\Services\BaseFeatures;
use App\Services\Chatting\Operations\BlockThreadOperation;
use App\Services\Chatting\Operations\IsThreadBelongToUserOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Feature;
use Throwable;

class BlockUserThreadFeature extends BaseFeatures
{
    private string $threadFuid;

    public function __construct(string $threadFuid)
    {
        $this->threadFuid = $threadFuid;
    }

    public function handle(Request $request)
    {
        $storeId = $request->get('store_id', null);
        $fuid    = $this->getOperatorFuid($storeId);

        $this->canBlock($fuid);
        $result = $this->block($fuid);

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

    /**
     * @throws Throwable
     */
    private function canBlock($fuid)
    {
        $isThreadBelongToUser = $this->run(IsThreadBelongToUserOperation::class, [
            'operatorFuid'  => $fuid,
            'threadFuid'    => $this->threadFuid,
        ]);

        throw_if(!$isThreadBelongToUser, ThreadDoesNotBelongToUserException::class);
    }

    private function block($fuid)
    {
        return $this->run(BlockThreadOperation::class, [
            'threadFuid' => $this->threadFuid,
            'userFuid'   => $fuid,
        ]);
    }
}
