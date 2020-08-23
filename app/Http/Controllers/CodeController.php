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
class CodeController extends Controller
{
    use LeaderBoardsTrait, FoodbankStatsTrait, UserStatsTrait;

    public function show(Goodiebag $goodiebag)
    {
        if($goodiebag->code == null) {
            return redirect('/')->withErrors('Invalid code.');
        }
        // If user tries to access page without having the
        // Cookie variable
        
        return view('code.show')->with('goodiebag', $goodiebag);
    }

    public function showConfirm()
    {
        // Check if user is logged in
        if(!Auth::check()) {
            return redirect()->withErrors('Unauthorized');
        }
        // Check if user is a foodbank
        if(!auth()->user()->isFoodbank) {
            return back()->withErrors('Unauthorized');
        }
        return view('code.confirm');
    }

    public function confirm(Request $request)
    {
        if(!$this->validateCode($request)) {
            return redirect()->route('show.confirm_code')->withErrors('Invalid code');
        }
        return redirect()->route('show.confirm_code')->with('success_message', 'Goodiebag received!');  
    }
    public function qrConfirm(Goodiebag $goodiebag)
    {
        if(!$this->validateCode(request())) {
            return redirect()->route('show.confirm_code')->withErrors('Invalid code.');
        }
        return redirect()->route('show.confirm_code')->with('success_message', 'Goodiebag received!');  
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
