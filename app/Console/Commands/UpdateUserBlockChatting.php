<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateUserBlockChatting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-block-chatting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all user have block chatting in current day';

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
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d');
        User::where('block_chatting_expired', $now)->update([
            'battery_point' => 600,
            'battery_level' => 3,
            'block_chatting_expired' => null
        ]);
    }
}
