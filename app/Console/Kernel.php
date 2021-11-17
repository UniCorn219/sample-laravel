<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('keyword:ranking')->dailyAt('00:00');
        $schedule->command('top-keyword:week')->dailyAt('00:00');
        $schedule->command('top-keyword:month')->dailyAt('00:00');
        $schedule->command('promotion:clear')->everyMinute();
        $schedule->command('otp:clear')->dailyAt('00:00');
        $schedule->command('user:mission')->dailyAt('00:00');
        $schedule->command('product-top:clear')->dailyAt('00:00');
        $schedule->command('user:update-block-chatting')->dailyAt('00:00');
        $schedule->command('user:update-user-battery-when-high-reply-message-rate')->dailyAt('00:00')->when(function () {
            return Carbon::now()->endOfMonth()->isToday();
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
