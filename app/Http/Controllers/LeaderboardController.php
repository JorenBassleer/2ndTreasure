<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WeeklyLeaderBoard;
use App\AllTimeLeaderBoard;
class LeaderboardController extends Controller
{
    public function index()
    {
        return view('leaderboard.index')->with([
            'this_week' => WeeklyLeaderBoard::orderBy('amount_of_kg','desc')->paginate(10),
            'all_time' => AllTimeLeaderBoard::orderBy('amount_of_kg','desc')->paginate(10)
        ]);
    }
}
