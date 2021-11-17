<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Area;
use JetBrains\PhpStorm\ArrayShape;
use Lucid\Units\Job;

class CalculatePromotionPriceByAreaJob extends Job
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
    #[ArrayShape(['total_user' => "int|mixed", 'price' => "float|int", 'count_day' => "int"])]
    public function handle(): array
    {
        $totalUser = Area::whereIn('id', $this->param['areas'])
            ->sum('total_user');

        return [
            'total_user' => $totalUser,
            'price'      => $this->calcPrice($totalUser, (int) $this->param['count_day']),
            'count_day'  => (int) $this->param['count_day'],
        ];
    }

    public function calcPrice(int $totalUser, int $countDay): float|int
    {
        // ($totalUser(people) / 300(people)) * 2000(won) * 1.5 * $countDay
        // 2000 * 1.5 / 300 = 10
        // => $totalUser * 10 * $countDay
        return $totalUser * 10 * $countDay;
    }
}
