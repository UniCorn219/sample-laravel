<?php

namespace App\Domains\Statistic\Jobs;

use App\Models\StatisticsUserActivity;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsUserActivityJob extends QueueableJob
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
        $dataInsert = [
            'user_id' => $this->user->id,
            'statistics_date' => $this->data['statistics_date'],
            'total_activities' => $this->data['total_activities'] ?? 0,
            'total_likes' => $this->data['total_likes'] ?? 0,
            'total_product' => $this->data['total_product'] ?? 0,
            'total_product_complete' => $this->data['total_product_complete'] ?? 0,
        ];

        $dataUpdate = [];
        $this->formatData($dataUpdate);

        StatisticsUserActivity::upsert(
            $dataInsert,
            [
                'statistics_date',
                'user_id',
            ],
            $dataUpdate
        );
    }

    private function formatData(&$data)
    {
        $table = StatisticsUserActivity::query()->getModel()->getTable();

        if (Arr::get($this->data, 'total_activities')) {
            $data['total_activities'] = DB::raw("$table.total_activities + 1");
        }

        if (Arr::get($this->data, 'total_likes')) {
            $value = Arr::get($this->data, 'total_likes', 1);
            $data['total_likes'] = DB::raw("GREATEST($table.total_likes + $value, 0)");
        }

        if (Arr::get($this->data, 'total_product')) {
            $value = Arr::get($this->data, 'total_product', 1);
            $data['total_product'] = DB::raw("GREATEST($table.total_product + $value, 0)");
        }
        if (Arr::get($this->data, 'total_product_complete')) {
            $value = Arr::get($this->data, 'total_product_complete', 1);
            $data['total_product_complete'] = DB::raw("GREATEST($table.total_product_complete + $value, 0)");
        }
    }
}
