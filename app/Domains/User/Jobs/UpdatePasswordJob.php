<?php

namespace App\Domains\User\Jobs;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Lucid\Units\Job;
use Throwable;

class UpdatePasswordJob extends Job
{
    private int    $userId;
    private string $oldPassword;
    private string $newPassword;

    /**
     * UpdatePasswordJob constructor.
     * @param int $userId
     * @param string $oldPassword
     * @param string $newPassword
     */
    public function __construct(int $userId, string $oldPassword, string $newPassword)
    {
        $this->userId      = $userId;
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle()
    {
        $response = Http::asMultipart()
            ->post(config('services.domain.dutta') . '/api/master/update_password', [
                'user_id'      => $this->userId,
                'old_password' => $this->oldPassword,
                'new_password' => $this->newPassword,
            ]);

        return $response->status() == 200;
    }
}
