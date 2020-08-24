<?php

namespace App\Console;

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
        // Update user stats
        // We already do this dynamically when user creates a goodiebag
        $schedule->command('command:updateUserStats')
                ->weeklyOn(7, '8:00');
        // New week so new leaderboard
        $schedule->command('command:clearWeeklyLeaderBoardTable')
                ->weeklyOn(7, '23:00');
        // Update website stats
        $schedule->command('command:updateWebsiteStats')
                ->weekly();
        // Flag bad users
        $schedule->command('command:checkUsersUndeliverd')
                ->weekly();
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
