<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goodiebag;
use App\User;
use App\UserStats;
use App\FoodbankStats;
use App\WeeklyLeaderBoard;
use App\WeeklyUserStats;
use App\WebsiteStats;
use App\Traits\LeaderBoardsTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\FlaggedUsersMail;
use App\UserRating;
use App\WeeklyFoodbankStats;
use Config;

class CronController extends Controller
{
    use LeaderBoardsTrait;

    public function cleanDatabase()
    {
        $emptyRows = Goodiebag::whereNull(['foodbank_id', 'status_id'])->get();
        if($emptyRows == null) {
            return response()->json('No empty rows', 200);
        }
        foreach($emptyRows as $emptyRow) {
            $emptyRow->delete();
        }
        return response()->json('Database cleaned', 200);
    }

    public function testing()
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
