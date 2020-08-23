<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Response;
class CookieController extends Controller
{
    // Delete goodiebag_id cookie on log out
    // 
    public function destroyCookie()
    {
        // Check if cookie exists
        if(Cookie::get('goodiebag_id') != null) {
            Cookie::queue(Cookie::forget('goodiebag_id'));
            return back();
        }
    }
}
