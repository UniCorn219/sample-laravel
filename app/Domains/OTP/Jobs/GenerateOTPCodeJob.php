<?php

namespace App\Domains\OTP\Jobs;

use Illuminate\Support\Str;
use Lucid\Units\Job;

class GenerateOTPCodeJob extends Job
{
    public function __construct(
        private int $length = 6,
        private bool $onlyNumber = true
    ) {
    }

    public function handle(): string
    {
        if (!$this->onlyNumber) {
            return Str::upper(Str::random($this->length));
        }

        $min = pow(10, $this->length - 1);

        return (string) mt_rand($min, 10 * $min - 1);
    }
}
