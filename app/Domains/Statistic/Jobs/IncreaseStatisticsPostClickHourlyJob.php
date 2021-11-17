<?php

namespace App\Domains\Statistic\Jobs;

use App\Models\StatisticsUserAges;
use App\Models\StatisticsUserHourlyClick;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPostClickHourlyJob extends QueueableJob
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
            'total_clicks' => 1,
        ];

        $table = StatisticsUserHourlyClick::query()->getModel()->getTable();
        StatisticsUserHourlyClick::upsert(
            $data,
            [
                'statistics_date',
                'statistics_hour',
                'user_id',
            ],
            [
                'total_clicks' => DB::raw($table . '.total_clicks + 1'),
            ]
        );
    }
}
