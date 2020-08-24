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
use App\UserRating;
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

        $users = User::onlyNormalUsers()->get();
        foreach($users as $user) {
            // Get amount of undelivered goodiebags of the user
            $amount = Goodiebag::where('user_id', $user->id)
                            ->whereIn('hasReceived', [null, 0])->count();
            // Get rating of user
            $rating = $user->userratings()->avg('rating');
            if($amount > 10 && $rating < 2) {
                $user->isFlagged = 1;
                $user->save();
            }
        }
    }
}
