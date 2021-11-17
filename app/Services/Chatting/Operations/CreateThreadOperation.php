<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\FindThreadByKeyJob;
use App\Domains\Chatting\Jobs\Thread\CreateThreadJob;
use App\Domains\Chatting\Jobs\GetProductInfoJob;
use App\Domains\Chatting\Jobs\Thread\CreateUserThreadJob;
use App\Domains\Chatting\Jobs\Thread\GetThreadInfoJob;
use App\Domains\Chatting\Jobs\UpdateUserThreadJob;
use App\Domains\Product\Jobs\RecountProductTotalChatJob;
use App\Domains\Product\Jobs\RestoreProductThreadJob;
use App\Exceptions\ResourceNotFoundException;
use App\Helpers\Common;
use App\Models\Firestore\Thread;
use App\Models\Firestore\UserThread;
use Exception;
use Google\Cloud\Core\Timestamp;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Operation;

class CreateThreadOperation extends Operation
{
    private string $userFuid;

    private string $otherUserFuid;

    private int $otherUserId;

    private int|null $productId;

    private int|null $userId;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(string $userFuid, string $otherUserFuid, int $otherUserId, int|null $productId, int|null $userId = null)
    {
        // OTHER USER is seller
        // USER is buyer
        $this->userFuid      = $userFuid;
        $this->otherUserFuid = $otherUserFuid;
        $this->productId     = $productId;
        $this->userId        = $userId;
        $this->otherUserId   = $otherUserId;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
        $product = is_null($this->productId) ? null : $this->run(GetProductInfoJob::class, [
            'productId' => $this->productId,
        ]);

        if (!is_null($product) && !in_array($product->author_id, [$this->userId, $this->otherUserId])) {
            throw new ResourceNotFoundException('product_not_found');
        }

        if (!is_null($product) && ($product->author_id == $this->userId)) {
            $tmpFuid             = $this->otherUserFuid;
            $this->otherUserFuid = $this->userFuid;
            $this->userFuid      = $tmpFuid;
        }

        $key    = $this->generateKey();
        $thread = $this->findThreadByKey($key);

        if (!is_null($thread)) {
            $userThread = UserThread::query()
                                    ->where('thread_fuid', $thread->id)
                                    ->where('user_fuid', $this->userFuid)
                                    ->first();
            $this->run(UpdateUserThreadJob::class, [
                'values' => [
                    'is_deleted' => false,
                ],
                'docId'  => $userThread->id,
            ]);

            $this->run(RestoreProductThreadJob::class, ['threadFuid' => $thread->id]);
            $this->run(RecountProductTotalChatJob::class, ['id' => $this->productId]);

            return $thread->toArray();
        }

        $threadFuid = $this->run(CreateThreadJob::class, [
            'product'       => $product,
            'userFuid'      => $this->userFuid,
            'otherUserFuid' => $this->otherUserFuid,
            'key'           => $key,
        ]);

        $this->run(CreateUserThreadJob::class, [
            'userFuid'      => $this->userFuid,
            'threadFuid'    => $threadFuid,
            'otherUserFuid' => $this->otherUserFuid,
        ]);

        $this->run(CreateUserThreadJob::class, [
            'userFuid'      => $this->otherUserFuid,
            'threadFuid'    => $threadFuid,
            'otherUserFuid' => $this->userFuid,
        ]);

        return $this->run(GetThreadInfoJob::class, ['threadFuid' => $threadFuid]);
    }

    private function findThreadByKey(string $key)
    {
        return $this->run(FindThreadByKeyJob::class, ['key' => $key]);
    }

    private function generateKey(): string
    {
        return Common::generateThreadKey([
            $this->userFuid,
            $this->otherUserFuid,
        ], $this->productId);
    }
}
