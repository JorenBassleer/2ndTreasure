<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goodiebag;
use Illuminate\Support\Facades\Cookie;
use App\WeeklyLeaderBoard;
// use App\Traits\LeaderBoardsTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
class CodeController extends Controller
{
    // use LeaderBoardsTrait;
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
            return back()->withErrors('Invalid code.');
        }
        return redirect()->route('show.confirm_code')->with('success_message', 'Goodiebag received!');  
    }
    public function qrConfirm(Goodiebag $goodiebag)
    {
        if(!$this->validateCode(request())) {
            return back()->withErrors('Invalid code.');
        }
        return redirect()->route('show.confirm_code')->with('success_message', 'Goodiebag received!');  
    }
    public function checkIfDelivered(Goodiebag $goodiebag)
    {
        if($goodiebag->hasReceived == null || $goodiebag->hasReceived == 0) {
            return back()->withErrors('Your code hasn\'t been confirmed yet. If it has, wait a few seconds and try again');
        }
        // Check if user is already logged in
        // And is the one connected with goodiebag
        if(Auth::check()) {
            if($goodiebag->user_id == auth()->user()->id) {
                // If so, we already added the treasures to his account
                // Delete cookie
                Cookie::queue(Cookie::forget('goodiebag_id'));
            }
        }
        // So the code can't get used again
        // And no duplicates will be created
        $goodiebag->code = null;
        $goodiebag->save();
        return view('thankyou')->with([
            'goodiebag' => $goodiebag,
        ]);
    }

    protected function validateCode(Request $request)
    {
        // Foodbank is the one going through this
        // Code submitted doesn't exist
        // Or isn't associated with foodbank
        if(!Goodiebag::where(
            ['code' => $request->code],
            ['foodbank_id' => auth()->user()->id]
            )->count() > 0 ) {
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
                // Add treasures to user's row
                $user->treasures += $goodiebag->treasures;
                // Check if user has row in UserStats
                if($user->userstat != null) {
                    // Add amount of kg's donated to stats table
                    $user->userstat->total_amount_of_kg_donated += $goodiebag->total_kg;
                    $user->userstat->save();
                }
                else {
                    // ADD to userstats
                    $user->userstat()->create(['total_amount_of_kg_donated' =>  $goodiebag->total_kg]);
                }
                $user->save();
                // Add user to Leaderboard - weekly & all time
                // Check if user 
                $this->addToLeaderBoards($goodiebag->total_kg,$user);
            }
            //
            //  ADD STATS of Foodbank
            //
            $foodbank = $goodiebag->foodbank;
            
            $this->addFoodbankStats($foodbank, $goodiebag);
            
            $goodiebag->save();
            return true;
        }
    }

    protected function addToLeaderBoards($weight, $user)
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
        return true;
    }   
    protected function addFoodbankStats($foodbank, $goodiebag)
    {
        if(!$foodbank->foodbankstat > null) {
            // create one variable since i can't put 1 into the create for some reason
            $one = 1;
            $foodbank->foodbankstat()->create([
                'total_amount_of_kg_received' => $goodiebag->total_kg,
                'total_amount_of_treasures_generated' => $goodiebag->treasures,
                'total_amount_of_goodiebags_received' => $one,
            ]);
        }
        else {
            $foodbank->foodbankstat->total_amount_of_kg_received +=$goodiebag->total_kg;
            $foodbank->foodbankstat->total_amount_of_treasures_generated +=$goodiebag->treasures;
            $foodbank->foodbankstat->total_amount_of_goodiebags_received += 1;
        }
        // dd($foodbank->foodbankstat);
        $foodbank->foodbankstat->save();
    }
}
