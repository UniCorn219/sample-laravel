<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Lucid\Units\Job;

class UpdateBlockChattingForUserJob extends Job
{
    private int $userId;
    private int $numer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $number)
    {
        $this->userId = $userId;
        $this->numer = $number;
    }

    /**
     * Execute the job.
     *
     * @return bool|int
     */
    public function handle(): bool|int
    {
        $expiredDay = $this->getDayExpired();
        $dataUpdate = [
            'number_of_time_block_chatting' => $this->numer + 1,
            'block_chatting_expired' => Carbon::now()->addDays($expiredDay),
        ];

        $user = User::find($this->userId);

        if ($user) {
            return User::whereId($this->userId)->update($dataUpdate);
        }

        return false;
    }

    private function getDayExpired(): int|string
    {
        $number = $this->numer + 1; // next time will increase 1 unit
        return match($number) {
            1 => 7,
            2 => 14,
            3 => 30,
            4 => 60,
            5 => 36500,
            default => 0
        };
    }
}
