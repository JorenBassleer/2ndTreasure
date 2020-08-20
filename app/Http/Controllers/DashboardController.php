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
            $foodbankStats = $foodbank->foodbank->foodbankstat;
            // dd($foodbankStats);

            return view('dashboard.index')->with([
                'foodbankStats' => $foodbankStats,
                'isFoodbank' => 1,   
            ]);
        }
        // Logged in user is normal user
        $user = auth()->user();
        // Check if user has just created account
        $minutesAgo = Carbon::now()->subMinutes(5);
        // This is to avoid double treasure pay out
        // And account that created an account after
        // delivering the goodiebag still receive a goodiebag
        
        // Check if there is a goodiebag_id in session
        // If so, add to user and forget session
        if(session()->has('goodiebag_id') && $user->created_at->lt($minutesAgo)) {
            $goodiebag = Goodiebag::find(session()->get('goodiebag_id'));
            $treasures = $goodiebag->treasures;
            $user->treasures += $treasures;
            session()->forget('goodiebag_id');
            $user->save();
        }
        // Get stats from user
        $userStats = $user->userstat;
        return view('dashboard.index')->with([
            'userStats' => $userStats,
            'isFoodbank' => 0,   
        ]);
    }
}
