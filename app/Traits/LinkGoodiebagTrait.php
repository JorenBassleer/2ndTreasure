<?php

namespace App\Traits;
use Illuminate\Support\Facades\Cookie;
use App\Goodiebag;
use App\Traits\LeaderBoardsTrait;
use App\Traits\UserStatsTrait;

trait LinkGoodiebagTrait
{
    use LeaderBoardsTrait, UserStatsTrait;
    protected function linkUserToGoodiebag($user)
    {
        // If user created a goodiebag without logging in
        // We attach the goodiebag with the user here
        if(Cookie::get('goodiebag_id') != null) {
            // Check if goodiebag has alreacy been delivered
            $goodiebag = Goodiebag::find(Cookie::get('goodiebag_id'));
            // Attach goodiebag to the user
            $goodiebag->user_id = $user->id;
            if($goodiebag->hasReceived == 1) {
                // Add treasures to user AND leaderboards->trait
                // + add stats
                $this->addUserStats($user, $goodiebag);
                $this->addToLeaderboards($user, $goodiebag->total_kg);
                $goodiebag->user_id = $user->id;
                $goodiebag->code = null;

            }
            $goodiebag->save();
            // Delete Cookie
            Cookie::queue(Cookie::forget('goodiebag_id'));
        }
    }
}