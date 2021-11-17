<?php

namespace App\Domains\LocalInfo\Jobs;

use App\Models\LocalInfo;
use Illuminate\Support\Collection;
use Lucid\Units\Job;


class GetSimpleLocalinfoJob extends Job
{
    public function __construct(private array $ids)
    {
    }

    public function handle(): Collection
    {
        return LocalInfo::whereIn('id', $this->ids)->get();
    }
}
