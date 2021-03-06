<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Goodiebag;
use Carbon\Carbon;
use App\FoodbankStats;
use App\WeeklyFoodbankStats;
use App\WeeklyUserStats;
use App\WeeklyUserkStats;
class DashboardController extends Controller
{
    public function index()
    {
        // Get lor labels in graphs
        $fourWeeksAgo = Carbon::now()->subWeeks(4)->format('d/m/Y');
        $threeWeeksAgo = Carbon::now()->subWeeks(3)->format('d/m/Y');
        $twoWeeksAgo = Carbon::now()->subWeeks(2)->format('d/m/Y');
        $oneWeeksAgo = Carbon::now()->subWeeks(1)->format('d/m/Y');
        // Get time now
        $aWeekAgo = Carbon::now()->subDays(7);

        if(auth()->user()->isFoodbank == 1) {
            // Logged in user is foodbank
            $foodbank = auth()->user();
            $foodbankStats = $foodbank->weeklyfoodbankstats;
            $stats = WeeklyFoodbankStats::where([
                ['user_id', auth()->user()->id],
                ['created_at', '>=', $fourWeeksAgo]
                ])->orderBy('created_at', 'asc')->take(4)->get();

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
                'fourWeeksAgo' => $fourWeeksAgo,
                'threeWeeksAgo' => $threeWeeksAgo,
                'twoWeeksAgo' => $twoWeeksAgo,
                'oneWeeksAgo' => $oneWeeksAgo,
                'stats' => $stats,
            ]);
        }
        // Logged in user is normal user
        $user = auth()->user();
        // Get stats from user
        $userStats = $user->weeklyuserstats;
        $stats = WeeklyUserStats::where([
            ['user_id', auth()->user()->id],
            ['created_at', '>=', $fourWeeksAgo]
            ])->orderBy('created_at', 'asc')->take(4)->get();
        return view('dashboard.index')->with([
            'userStats' => $userStats == null ? 0 : $userStats,
            'treasures' => $user->treasures == null ? 0 : $user->treasures,
            'isFoodbank' => 0,
            'fourWeeksAgo' => $fourWeeksAgo,
            'threeWeeksAgo' => $threeWeeksAgo,
            'twoWeeksAgo' => $twoWeeksAgo,
            'oneWeeksAgo' => $oneWeeksAgo,
            'stats' => $stats,
        ]);
    }
}
