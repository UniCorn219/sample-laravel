<?php

namespace App\Domains\Statistic\Jobs;

use App\Enum\AgeRange;
use App\Models\StatisticsUserAges;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPostClickAgeJob extends QueueableJob
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
        $age = $this->getAge();
        if ($age > 0) {
            $data = [
                'user_id' => $this->user->id,
                'age_range' => AgeRange::getAgeRange($age),
                'statistics_date' => $this->data['statistics_date'],
                'total_clicks' => 1,
            ];

            $table = StatisticsUserAges::query()->getModel()->getTable();
            StatisticsUserAges::upsert(
                $data,
                [
                    'statistics_date',
                    'age_range',
                    'user_id',
                ],
                [
                    'total_clicks' => DB::raw($table . '.total_clicks + 1'),
                ]
            );
        }
    }

    protected function getAge(): int
    {
        $date = $this->initCarbonDate($this->user->birth ?? null);
        if (!$date) {
            return 0;
        }

        return $date->diffInYears(Carbon::now());
    }

    protected function initCarbonDate(?string $value = null): bool|Carbon|null
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        } catch (Exception) {
            $date = null;
        }

        return $date;
    }
}
