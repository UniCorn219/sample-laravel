<?php

namespace App\Domains\Point\Jobs;

use App\Exceptions\BaseException;
use App\ValueObjects\Amount;
use Illuminate\Support\Facades\Http;
use Lucid\Units\Job;
use Throwable;

class UpdatePointJob extends Job
{
    private int $userId;
    private Amount $amount;
    private string $reason;

    /**
     * Create a new job instance.
     *
     * @param  int  $userId
     * @param  Amount  $amount
     * @param  string  $reason
     */
    public function __construct(int $userId, Amount $amount, string $reason)
    {
        $this->userId = $userId;
        $this->amount = $amount;
        $this->reason = $reason;
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle()
    {
        $response = Http::asMultipart()
            ->post(config('services.domain.dutta').'/api/point/update', [
                'user_id' => $this->userId,
                'point'   => $this->amount->amount(),
                'reason'  => $this->reason,
            ]);

        throw_if(
            $response->status() != 200,
            BaseException::class,
            __('messages.payment.update_point_fail'),
        );
    }
}
