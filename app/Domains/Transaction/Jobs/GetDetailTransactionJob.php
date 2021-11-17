<?php

namespace App\Domains\Transaction\Jobs;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class GetDetailTransactionJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return Model|null|Transaction
     */
    public function handle(): Model|null|Transaction
    {
        return Transaction::with(['product', 'seller', 'buyer']) ->find($this->id);
    }
}
