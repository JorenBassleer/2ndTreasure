<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\WeeklyUserStats;
class UpdateWeeklyUserStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateWeeklyUserStats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the weekly stats of the users';

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
        // Get all foodbanks
        $users = User::onlyNormalUsers()->get();
        foreach($users as $user) {   
            // Check if User has stats
            if(WeeklyUserStats::where('user_id', $user->id)->count() == null) {
                if($user->userstat != null) {
                    $weeklyUserStats = new WeeklyUserStats;
                    $weeklyUserStats->user_id = $user->id;
                    $weeklyUserStats->amount_of_kg_donated = $user->userstat->total_amount_of_kg_donated;
                    $weeklyUserStats->number_of_treasures = $user->userstat->highest_number_of_treasures;
                    $weeklyUserStats->save();
                }
            }
            else {
                // Get stat of prev
                $previousWeekStat = WeeklyUserStats::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
                // Check 
                // Get the difference of previous week stat and current
                $diffKg = $user->userstat->total_amount_of_kg_donated - $previousWeekStat->amount_of_kg_received;
                $diffTreasures = $user->userstat->highest_number_of_treasures - $previousWeekStat->number_of_treasures;
                $weeklyUserStats = new WeeklyUserStats;
                $weeklyUserStats->user_id = $user->id;
                $weeklyUserStats->amount_of_kg_donated = $diffKg;
                $weeklyUserStats->number_of_treasures = $diffTreasures;
                $weeklyUserStats->save();
            }
        }
    }
}
