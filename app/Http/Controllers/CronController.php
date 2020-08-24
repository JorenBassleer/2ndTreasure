<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goodiebag;
use App\User;
use App\UserStats;
use App\FoodbankStats;
use App\WeeklyLeaderBoard;
use App\WebsiteStats;
use App\Traits\LeaderBoardsTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\FlaggedUsersMail;
use App\UserRating;
use Config;

class CronController extends Controller
{
    use LeaderBoardsTrait;

    public function cleanDatabase()
    {
        $emptyRows = Goodiebag::whereNull(['foodbank_id', 'status_id'])->get();
        if($emptyRows == null) {
            return response()->json('No empty rows', 200);
        }
        foreach($emptyRows as $emptyRow) {
            $emptyRow->delete();
        }
        return response()->json('Database cleaned', 200);
    }

    public function testing()
    {
        $flaggedUsers = User::onlyNormalUsers()->where('isFlagged', 1)->get();
        // Send mail to admin
        try {
            Mail::to(config('mail.from.address'))
            ->send(new FlaggedUsersMail($flaggedUsers));
        } catch(Exception $e) {
            return $e;
        }

    }
}
