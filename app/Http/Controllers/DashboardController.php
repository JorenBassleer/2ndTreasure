<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Goodiebag;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {

        if(auth()->user()->isFoodbank == 1) {
            // Logged in user is foodbank
            $foodbank = auth()->user();
            $foodbankStats = $foodbank->foodbankstat;
            // Get time now
            $aWeekAgo = Carbon::now()->subDays(7);
            // Get goodiebags that foodbank has received
            // Only the recently ones
            $pastRecentGoodiebags = Goodiebag::where([
                ['foodbank_id', auth()->user()->id],
                ['hasReceived', 1],
                ['updated_at', '>', $aWeekAgo]
            ])->paginate(5);
            // dd($foodbankStats);
            return view('dashboard.index')->with([
                'foodbankStats' => $foodbankStats == null ? 0 : $foodbankStats,
                'isFoodbank' => 1,
                'pastRecentGoodiebags' => $pastRecentGoodiebags,
            ]);
        }
        // Logged in user is normal user
        $user = auth()->user();
        // Get stats from user
        $userStats = $user->userstat;
        return view('dashboard.index')->with([
            'userStats' => $userStats == null ? 0 : $userStats,
            'treasures' => $user->treasures == null ? 0 : $user->treasures,
            'isFoodbank' => 0,   
        ]);
    }
}
