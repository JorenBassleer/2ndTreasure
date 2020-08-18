<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goodiebag;
class CodeController extends Controller
{
    public function show(Goodiebag $goodiebag)
    {
        return view('code')->with('goodiebag', $goodiebag);
    }
}
