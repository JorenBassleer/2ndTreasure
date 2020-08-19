<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goodiebag;
use Session;
use Illuminate\Support\Facades\Auth;
class CodeController extends Controller
{
    public function show(Goodiebag $goodiebag)
    {
        if($goodiebag->code == null) {
            return back()->withErrors('Invalid code.');
        }
        // Check if there is not a user logged in
        // This way if the user creates an account
        // And wants to collect the treasures
        // We can find everything associated with
        // the user
        if(!Auth::check()) {
            Session::put('goodiebag_id', $goodiebag->id);
        }
        return view('code.show')->with('goodiebag', $goodiebag);
    }

    public function showConfirm()
    {
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
            return back()->withErrors('It hasn\'t been delivered yet. If it has, wait a few moments and try again.');
        }
        // Calculate amount of treasures and send to view
        // if user is logged in add them to their account
        return view('thankyou')->with([
            'goodiebag' => $goodiebag,
        ]);
    }

    protected function validateCode(Request $request)
    {
        // Code submitted doesn't exist
        // Or isn't associated with foodbank
        if(!Goodiebag::where(
            ['code' => $request->code],
            ['foodbank_id' => auth()->user()->id]
            )->count() > 0 ) {
                return false;
        }
        else {
            $goodiebag = Goodiebag::where(['code' => $request->code],
                            ['foodbank_id' => auth()->user()->id])
                            ->first();
            // So the code can't get used again
            // And no duplicates will be created
            $goodiebag->code = null;
            // Foodbank has received goodiebag
            $goodiebag->hasReceived =1;
            //
            //  ADD STATS + KG + ...
            //
            $goodiebag->save();
            return true;
        }
    }
}
