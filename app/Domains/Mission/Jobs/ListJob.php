<?php

namespace App\Domains\Mission\Jobs;

use App\Models\Mission;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class ListJob extends Job
{
    /**
     * Execute the job.
     *
     * @return Collection|Mission[]
     */
    public function handle(): Collection|array
    {
        return Mission::all();
    }
}
