<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductTop;

class ClearProductTop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product-top:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear product top within day';

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
        ProductTop::query()->truncate();
        return true;
    }


}
