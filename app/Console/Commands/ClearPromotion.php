<?php

namespace App\Console\Commands;

use App\Services\Promotion\Features\ClearPromotionFeature;
use Illuminate\Console\Command;
use Lucid\Bus\ServesFeatures;

class ClearPromotion extends Command
{
    use ServesFeatures;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear promotion daily';

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
        $this->serve(ClearPromotionFeature::class);

        return true;
    }


}
