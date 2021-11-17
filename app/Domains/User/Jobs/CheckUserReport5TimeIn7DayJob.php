<?php

namespace App\Domains\User\Jobs;

use App\Models\UserReportUser;
use Carbon\Carbon;
use Lucid\Units\Job;

class CheckUserReport5TimeIn7DayJob extends Job
{
    private int $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return boolean
     */
    public function handle(): bool
    {
        $userId = $this->userId;
        $startTime = Carbon::now()->subDays(7)->format('Y-m-d 00:00:00');
        $endTime = Carbon::now()->format('Y-m-d 23:59:59');

        $data = UserReportUser::where('user_target_id', $userId)
            ->whereBetween('created_at', [$startTime, $endTime])
            ->get();

        return count($data) >= 5;
    }
}
