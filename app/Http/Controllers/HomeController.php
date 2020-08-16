<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Appeal;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $appealsNotRead = Appeal::whereHas('user', function ($query) {
            return $query->where([
                ['user_id', '=', auth()->user()->id],
                ['hasUserRead', '=', 0],
                ]);
        })->get();
        return view('home')->with([
            'foodbanks' => auth()->user()->foodbanks,
            // 'amountOfAppealsNotRead' => count($appealsNotRead),
        ]);
    }
}
