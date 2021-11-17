<?php

namespace App\Domains\Statistic\Jobs;

use App\Models\StatisticsUserHourlyActivity;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsUserActivityHourlyJob extends QueueableJob
{
    private array $data;
    private User $user;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @param User $user
     */
    public function __construct(array $data, User $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle()
    {
        $data = [
            'user_id' => $this->user->id,
            'statistics_date' => $this->data['statistics_date'],
            'statistics_hour' => $this->data['statistics_hour'],
            'total_activities' => 1,
        ];

        $table = StatisticsUserHourlyActivity::query()->getModel()->getTable();
        StatisticsUserHourlyActivity::upsert(
            $data,
            [
                'statistics_date',
                'statistics_hour',
                'user_id',
            ],
            [
                'total_activities' => DB::raw($table . '.total_activities + 1'),
            ]
        );
    }
}
