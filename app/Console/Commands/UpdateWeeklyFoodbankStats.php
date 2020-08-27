<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\WeeklyFoodbankStats;
class UpdateWeeklyFoodbankStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateWeeklyFoodbankStats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the weekly stats of the foodbanks';

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
        $foodbanks = User::onlyFoodbanks()->get();
        foreach($foodbanks as $foodbank) {   
            // Check if foodbank has stats
            if(WeeklyFoodbankStats::where('user_id', $foodbank->id)->count() == null) {
                if($foodbank->foodbankstat != null) {
                    $weeklyFoodbankStats = new WeeklyFoodbankStats;
                    $weeklyFoodbankStats->user_id = $foodbank->id;
                    $weeklyFoodbankStats->amount_of_kg_received = $foodbank->foodbankstat->total_amount_of_kg_received;
                    $weeklyFoodbankStats->amount_of_treasures_generated = $foodbank->foodbankstat->total_amount_of_treasures_generated;
                    $weeklyFoodbankStats->amount_of_goodiebags_received = $foodbank->foodbankstat->total_amount_of_goodiebags_received;
                    $weeklyFoodbankStats->save();
                }
            }
            else {
                // Get stat of prev
                $previousWeekStat = WeeklyFoodbankStats::where('user_id', $foodbank->id)->orderBy('created_at', 'desc')->first();
                // Get the difference of previous week stat and current
                $diffKg = $foodbank->foodbankstat->total_amount_of_kg_received - $previousWeekStat->amount_of_kg_received;
                $diffTreasures = $foodbank->foodbankstat->total_amount_of_treasures_generated - $previousWeekStat->amount_of_treasures_generated;
                $diffGoodiebags = $foodbank->foodbankstat->total_amount_of_goodiebags_received - $previousWeekStat->amount_of_goodiebags_received;
                $weeklyFoodbankStats = new WeeklyFoodbankStats;
                $weeklyFoodbankStats->user_id = $foodbank->id;
                $weeklyFoodbankStats->amount_of_kg_received = $diffKg;
                $weeklyFoodbankStats->amount_of_treasures_generated = $diffTreasures;
                $weeklyFoodbankStats->amount_of_goodiebags_received = $diffGoodiebags;
                $weeklyFoodbankStats->save();
            }
        }
    }
}
