<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Promotion;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;
use Throwable;

class FindOrFailPromotionDetailJob extends Job
{
    private int $id;
    private array $with = [
        'categories',
        'areas',
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, array $with = [])
    {
        $this->id   = $id;
        $this->with = $with ?: $this->with;
    }

    /**
     * @return Promotion|Promotion[]|Collection|Model
     */
    public function handle(): Model|Collection|array|Promotion
    {
        $promotion = Promotion::findOrFail($this->id);

        return $promotion->load($this->with);
    }
}
