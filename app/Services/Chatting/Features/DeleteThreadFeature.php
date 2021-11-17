<?php

namespace App\Services\Chatting\Features;

use App\Models\Store;
use App\Services\BaseFeatures;
use App\Services\Chatting\Operations\DeleteStoreThreadOperation;
use App\Services\Chatting\Operations\DeleteThreadOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteThreadFeature extends BaseFeatures
{
    private string $threadFuid;

    public function __construct(string $threadFuid)
    {
        $this->threadFuid = $threadFuid;
    }

    public function handle(Request $request): JsonResponse
    {
        $storeId = $request->get('store_id', null);

        return $storeId ? $this->deleteStoreThread($storeId) : $this->deleteThread();
    }

    /**
     * @return JsonResponse
     */
    private function deleteThread(): JsonResponse
    {
        $user   = Auth::user();
        $result = $this->run(DeleteThreadOperation::class, [
            'user'       => $user,
            'threadFuid' => $this->threadFuid
        ]);

        return $this->responseOk($result);
    }

    /**
     * @param $storeId
     * @return JsonResponse
     */
    private function deleteStoreThread($storeId): JsonResponse
    {
        $store = Store::query()->where([
            'owner_id' => Auth::user()->id,
            'id'       => $storeId,
        ])->firstOrFail();

        $result = $this->run(DeleteStoreThreadOperation::class, [
            'store'      => $store,
            'threadFuid' => $this->threadFuid,
        ]);

        return $this->responseOk($result);
    }
}
