<?php

namespace App\Domains\User\Jobs;

use App\Enum\DynamicLinkObject;
use App\Models\User;
use App\Services\Firebase\DynamicLinkService;
use Illuminate\Support\Facades\Log;
use Lucid\Units\QueueableOperation;

class UpdateLinkShareJob extends QueueableOperation
{
    private int $userId;

    /**
     * UpdateLinkShareJob constructor.
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        $user = User::find($this->userId);

        try {
            $dynamicLinks     = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::USER, $user->id);
            $user->link_share = $dynamicLinks['shortLink'];
            $user->save();
        } catch (\Exception $exception) {
            Log::error('[ERROR][SyncCreateFeature][$dynamicLinks]: '.$exception);
        }

        return true;
    }
}
