<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
// use App\Foodbank;
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
        // Get stats from user
        $userStats = $user->userstat;
        return view('dashboard.index')->with([
            'userStats' => $userStats,
            'isFoodbank' => 0,   
        ]);
    }
}
