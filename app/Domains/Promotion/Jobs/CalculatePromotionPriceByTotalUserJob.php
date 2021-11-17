<?php

namespace App\Domains\Promotion\Jobs;

use Lucid\Units\Job;

class CalculatePromotionPriceByTotalUserJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @param  array  $param
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     */
    public function handle(): int
    {
        // ($totalUser(people) / 300(people)) * 2000(won) * 1.5 * $countDay
        // 2000 * 1.5 / 300 = 10
        // => $totalUser * 10 * $countDay
        return (int)$this->param['total_user'] * 10 * $this->param['count_day'];
    }
}
