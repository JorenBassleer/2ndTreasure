<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goodiebag;
use App\User;
use App\UserStats;
use App\FoodbankStats;
use App\WeeklyLeaderBoard;
use App\WebsiteStats;
use App\Traits\LeaderBoardsTrait;
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
            // Get all the non foodbank users
        $users =  User::where('isFoodbank', null)
                    ->orWhere('isFoodbank', 0)->get();
        // Loop through
        foreach($users as $user) {
            $place = $this->checkPlaceInAlltimeLeaderBoard($user);
            // For convenience, so all lines won't be really long
            $stats = UserStats::where('user_id', $user->id)->first();
            // Check if user has stats
            if($stats == null) {
                // User has no stats yet so create new one
                $stats = new UserStats;
                // Place in leaderboards
                $stats->user_id = $user->id;
                // Check if user is in leaderboards or not. Add null in case not
                $stats->highest_place_ever = $place != null ? $place : null;
                // Add amount treasures
                $stats->highest_number_of_treasures = $user->treasures;
                // Add total amount of kg donated already happens when user has delivered goodiebag
            } else {
                // Check if variables are null, if so set value
                if($stats->highest_place_ever == null) {
                    $stats->highest_place_ever = $place;
                }
                if($stats->highest_number_of_treasures == null) {
                    $stats->highest_number_of_treasures = $user->treasures;
                }
                // Check if stats are higher than "new" stats
                // opposite since place 1 is higher than  2
                if($place < $stats->highest_place_ever) {
                    $stats->highest_place_ever = $place;
                }
                // Check if stats have increased
                if($user->treasures > $stats->highest_number_of_treasures) {
                    $stats->highest_number_of_treasures = $user->treasures;
                }
            }
            // Save the stats of user
            $stats->save();
        }
    }
}
