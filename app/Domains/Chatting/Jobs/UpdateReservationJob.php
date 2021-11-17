<?php

namespace App\Domains\Chatting\Jobs;

use App\Models\Firestore\Message;
use App\Models\Reservation;
use Carbon\Carbon;
use Lucid\Units\Job;

class UpdateReservationJob extends Job
{
    private int   $id;
    private array $attributes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, array $attributes)
    {
        $this->id = $id;
        $this->attributes = $attributes;
    }

    public function handle()
    {
        $reservation = Reservation::query()->findOrFail($this->id);
        $reservation->update($this->attributes);

        return $reservation;
    }
}
