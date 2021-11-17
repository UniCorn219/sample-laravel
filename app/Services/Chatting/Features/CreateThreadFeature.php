<?php

namespace App\Services\Chatting\Features;

use App\Domains\Chatting\Jobs\CreateUserChatsJob;
use App\Domains\Chatting\Requests\CreateThreadRequest;
use App\Models\User;
use App\Services\Chatting\Operations\CreateThreadOperation;
use App\Services\Chatting\Operations\GetUserFuidOperation;
use App\Services\Store\Features\BaseFeatures;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CreateThreadFeature extends BaseFeatures
{
    /**
     * @throws Exception
     */
    public function handle(CreateThreadRequest $request): JsonResponse
    {
        $user = Auth::user();

        $productId   = $request->get('product_id');
        $otherUserId = $request->get('other_user_id');

        $otherUser = User::query()->findOrFail($otherUserId);

        $userFuid      = $this->run(GetUserFuidOperation::class, ['userId' => $user->id]);
        $otherUserFuid = $this->run(GetUserFuidOperation::class, ['userId' => $otherUserId]);

        $thread = $this->run(CreateThreadOperation::class, [
            'userFuid'      => $userFuid,
            'otherUserFuid' => $otherUserFuid,
            'productId'     => $productId,
            'userId'        => $user->id,
            'otherUserId'   => $otherUser->id,
        ]);

        $this->run(CreateUserChatsJob::class, [
            'userId'        => $user->id,
            'userTargetId'  => $otherUserId,
            'threadId'      => $thread['id'],
            'isFromProduct' => (bool)$productId
        ]);

        return $this->responseOk($thread);
    }
}
