<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WebsiteStats;
use App\Goodiebag;
class LandingPageController extends Controller
{
    public function displayLandingPage()
    {
        return view('landing_page')->with([
            'kg_donated' => round(WebsiteStats::first()->amount_of_kg_donated),
            'people_helped' => round(WebsiteStats::first()->amount_of_treasures_created),
            'goodiebags_created' => Goodiebag::where('hasReceived', 1)->count(),
        ]);
    }
}
