<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goodiebag;
use Illuminate\Support\Facades\Cookie;
use App\Traits\LeaderBoardsTrait;
use App\Traits\FoodbankStatsTrait;
use App\Traits\UserStatsTrait;
use App\FoodbankStats;
use App\User;
use Illuminate\Support\Facades\Auth;
use Storage;

class CodeController extends Controller
{
    use LeaderBoardsTrait, FoodbankStatsTrait, UserStatsTrait;

    public function show(Goodiebag $goodiebag)
    {
        if($goodiebag->code == null) {
            return redirect()->route('goodiebag.create')->withErrors('Invalid code.');
        }
        // If user tries to access page without having the
        // Cookie variable or is not connected with the cookie
        if(Auth::check()) {
            if(auth()->user()->id != $goodiebag->user_id) {
                return redirect()->route('goodiebag.create')->withErrors('Unauthorized');
            }
        }
        else {
            if(Cookie::get('goodiebag_id') == null) {
                return redirect()->route('goodiebag.create')->withErrors('Unauthorized');
            }
        }
        // Get style of google maps
        $json = Storage::disk('local')->get('json/map-style.json');
        $json = json_decode($json, true);
        return view('code.show')->with([
            'goodiebag' => $goodiebag,
            'styledMap' => $json,
            ]);
    }

    public function confirm(Request $request)
    {
        if(!$this->validateCode($request)) {
            return redirect()->route('dashboard.index')->withErrors('Invalid code');
        }
        return redirect()->route('dashboard.index')->with('success_message', 'Goodiebag received!');  
    }
    public function qrConfirm(Goodiebag $goodiebag)
    {
        if(!$this->validateCode(request())) {
            return redirect()->route('dashboard.index')->withErrors('Invalid code.');
        }
        return redirect()->route('dashboard.index')->with('success_message', 'Goodiebag received!');  
    }
    public function checkIfDelivered(Goodiebag $goodiebag)
    {
        // Check if goodiebag has been received
        if($goodiebag->hasReceived == null || $goodiebag->hasReceived == 0) {
            return back()->withErrors('Your code hasn\'t been confirmed yet. If it has, wait a few seconds and try again');
        }
        // Goodiebag has been received

        // Check if user is already logged in
        // And is the one connected with goodiebag
        if(Auth::check()) {
            if($goodiebag->user_id == auth()->user()->id) {
                // If so, we already added the treasures to his account
                // Delete cookie
                Cookie::queue(Cookie::forget('goodiebag_id'));
                // Set code to null so it can't get used again
                // And no duplicates will be created
                $goodiebag->code = null;
                $goodiebag->save();
            }
        }
        return view('thankyou')->with([
            'goodiebag' => $goodiebag,
        ]);
    }

    protected function validateCode(Request $request)
    {
        // Foodbank is the one going through this
        // Code submitted doesn't exist
        // Or isn't associated with foodbank
        if(!Goodiebag::where([
            ['code' , $request->code],
            ['foodbank_id' , auth()->user()->id]
            ])->count() > 0 ) {
                return false;
        }
        else {
            // Code is validated
            $goodiebag = Goodiebag::where(['code' => $request->code],
                            ['foodbank_id' => auth()->user()->id])
                            ->first();
            $user = User::find($goodiebag->user_id);
            // Foodbank has received goodiebag
            $goodiebag->hasReceived =1;
            // If user is logged in add treasures to User acc
            if($user > null) {
                // If user is flagged as bad user
                // Set back to 0 since he delivered a goodiebag
                if($user->isFlagged) {
                    $user->isFlagged = 0;
                    $user->save();
                }
                // Add to the users stats
                $this->addUserStats($user, $goodiebag);
                // Add user to Leaderboard - weekly & all time
                $this->addToLeaderBoards($user, $goodiebag->total_kg);
            }
            $foodbank = $goodiebag->foodbank;
            // Add stats to the foodbank
            $this->addFoodbankStats($foodbank, $goodiebag);
            
            $goodiebag->save();
            return true;
        }
    }
  
}
