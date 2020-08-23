<?php
namespace App\Traits;
use Illuminate\Http\Request;
use App\AllTimeLeaderBoard;
use App\User;

trait LeaderBoardsTrait {

    protected function addToLeaderBoards($user, $weight)
    {

        // Check if user is in leaderboards
        if($user->weeklyleaderboard == null) {
            // user is not in leaderboards yet
            $user->weeklyleaderboard()->create(['amount_of_kg' => $weight]);
        }
        else {
            // Add Weight
            $user->weeklyleaderboard->amount_of_kg += $weight;
            $user->weeklyleaderboard->save();

        }
        // Check if user is in leaderboards
        if($user->alltimeleaderboard == null) {
            // user is not in leaderboards yet
            $user->alltimeleaderboard()->create(['amount_of_kg' => $weight]); 
        }
        else {
           
            // Add Weight
            $user->alltimeleaderboard->amount_of_kg += $weight;
            $user->alltimeleaderboard->save();
        }
    }

    protected function checkPlaceInWeeklyLeaderBoard($user)
    {

        // Check if user is in weeklyleaderboard
        if($user->weeklyleaderboard == null) {
            // if not set place to null
            $place = null;
        }
        else {
            // Get the place of user by counting how many are above
            // + 1 since that is the place of user in DB
            $place = WeeklyLeaderBoard::where('amount_of_kg', '>', $user->weeklyleaderboard->amount_of_kg )->count() + 1;
            return $place;
        }
    }
    protected function checkPlaceInAlltimeLeaderBoard($user)
    {
       // Check if user is in weeklyleaderboard
        if($user->alltimeleaderboard == null) {
            // if not set place to null
            $place = null;
        }
        else {
            // Get the place of user by counting how many are above
            // + 1 since that is the place of user in DB
            $place = AllTimeLeaderBoard::where('amount_of_kg', '>', $user->alltimeleaderboard->amount_of_kg )->count() + 1;
            return $place;
        }
    }
}