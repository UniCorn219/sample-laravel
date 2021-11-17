<?php

namespace App\Domains\Promotion\Jobs;

use App\Models\Promotion;
use Illuminate\Support\Collection;
use Lucid\Units\Job;


class GetSimplePromotionsJob extends Job
{
    public function __construct(private array $ids)
    {
    }

    public function handle(): Collection
    {
        return Promotion::whereIn('id', $this->ids)->get();
    }
}
