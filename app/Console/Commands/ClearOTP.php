<?php

namespace App\Console\Commands;

use App\Services\OTP\Features\ClearOTPFeature;
use Illuminate\Console\Command;
use Lucid\Bus\ServesFeatures;

class ClearOTP extends Command
{
    use ServesFeatures;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear otp daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return boolean
     */
    public function handle(): bool
    {
        $this->serve(ClearOTPFeature::class);

        return true;
    }


}
