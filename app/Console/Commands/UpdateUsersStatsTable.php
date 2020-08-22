<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\UserStats;
class UpdateUsersStatsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateUsersStats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the stats table of users';

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
     * @return int
     */
    public function handle()
    {
        // All the stats for the user
        $users =  User::where('isFoodbank', null)
        ->orWhere('isFoodbank', 0)->get();
        foreach($users as $user) {
            if($user->weeklyleaderboard == null) {
                $place = null;
            }
            else {
                // Get the place of user by counting how many are above
                // + 1 since that is the place of user in DB
                $place = WeeklyLeaderBoard::where('amount_of_kg', '>', $user->weeklyleaderboard->amount_of_kg )->count() + 1;
            }
            // For convenience, so all lines won't be really long
            $stats = UserStats::where('user_id', $user->id)->first();
            // Check if user has stats
            if($stats == null) {
                $stats = new UserStats;
                // Place in leaderboards
                $stats->user_id = $user->id;
                // Check if user is in leaderboards or not. Add null in case not
                $stats->highest_place_ever = $place != null ? $place : null;
                // Highest place this week in another cron
                // Add amount treasures
                $stats->highest_number_of_treasures = $user->treasures;
                // Add total amount of kg donated already happens when user has delivered goodiebag
            } else {
                // User has stats row so we need to check if higher or not
                // opposite since place 1 is higher than 2
                if(!$this->isHigher($place, $stats->highest_place_ever)) {
                    $stats->highest_place_ever = $place;
                }
                // Check if stats have increased
                if($this->isHigher($user->treasures, $stats->highest_number_of_treasures)) {
                    $stats->highest_number_of_treasures = $user->treasures;
                }
            }
            // Save the stats of user
            $stats->save();
        }
    }
    public function isHigher($value1, $value2)
    {
        if($value1 > $value2) {
            return true;
        }
        else {
            false;
        }
    }
}
