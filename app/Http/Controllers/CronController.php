<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goodiebag;
use App\User;
use App\UserStats;
use App\FoodbankStats;
use App\WeeklyLeaderBoard;
use App\WebsiteStats;
class CronController extends Controller
{
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
    }

}
