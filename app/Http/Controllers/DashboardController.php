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
        $idk = Goodiebag::where('hasReceived', null)->whereNotNull('code')->with([
            'user' => function ($q) {
                return $q->where('id', auth()->user()->id)
                ->get();
            }
            ])->get();
            dd($idk);

            
            $hehe = auth()->user()->whereHas('goodiebags', function ($query) {
                return $query->where('hasReceived', null)
                             ->whereNotNull('code');
            })->get();
            dd($hehe);
        if(auth()->user()->isFoodbank == 1) {
            // Logged in user is foodbank
            $foodbank = auth()->user();
            $foodbankStats = $foodbank->foodbank->foodbankstat;
            // dd($foodbankStats);

            return view('dashboard.index')->with([
                'foodbankStats' => $foodbankStats == null ? 0 : $foodbankStats,
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
            // Add to stats of user
            $user->userstat()->create(['total_amount_of_kg_donated',  $goodiebag->total_kg]);
            session()->forget('goodiebag_id');
            $user->userstat->save();
            $user->save();
        }
        // Get stats from user
        $userStats = $user->userstat;
        return view('dashboard.index')->with([
            'userStats' => $userStats == null ? 0 : $userStats,
            'treasures' => $user->treasures == null ? 0 : $user->treasures,
            'isFoodbank' => 0,   
        ]);
    }
}
