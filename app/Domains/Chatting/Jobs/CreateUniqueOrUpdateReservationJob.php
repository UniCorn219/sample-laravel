<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\Message;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Lucid\Units\Job;

class CreateUniqueOrUpdateReservationJob extends Job
{
    private array $param;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        return Reservation::query()->updateOrCreate([
            'product_id' => $this->param['product_id'],
            'buyer_id'   => $this->param['buyer_id'],
            'seller_id'  => $this->param['seller_id'],
        ], $this->param);
    }
}
