<?php

namespace App\Domains\Point\Jobs;

use App\Models\TransferBank;
use Illuminate\Database\Eloquent\Collection;
use Lucid\Units\Job;

class GetListTransferBanksJob extends Job
{
    /**
     * Execute the job.
     */
    public function handle(): Collection
    {
        return TransferBank::all();
    }
}
