<?php

namespace App\Http\Controllers;

use App\Goodiebag;
use App\Food;
use App\Foodbank;
use App\FoodGoodiebag;
use Illuminate\Http\Request;

class GoodiebagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('goodiebag.create')->with([
            'foods'=> Food::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateGoodiebag($request);
        $goodiebag = new Goodiebag ([
            'user_id' => auth()->user()->id,
        ]);
        $goodiebag->save();
        // Foodbanks in the area of user maybe
        $this->addFoodToGoodiebag($goodiebag,$request->except('_token'));
        return view('goodiebag.select_foodbank')->with([
                                    'goodiebag'=>$goodiebag,
                                    'foodbanks' => Foodbank::all(),
                                                            ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Goodiebag  $goodiebag
     * @return \Illuminate\Http\Response
     */
    public function show(Goodiebag $goodiebag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Goodiebag  $goodiebag
     * @return \Illuminate\Http\Response
     */
    public function edit(Goodiebag $goodiebag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Goodiebag  $goodiebag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goodiebag $goodiebag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Goodiebag  $goodiebag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goodiebag $goodiebag)
    {
        //
    }

    protected function validateGoodiebag(Request $request) {
        if($request->validate([
            1 => 'integer',
            2 => 'integer',
            3 => 'integer',
            4 => 'integer',
            5 => 'integer',
            6 => 'integer',
            7 => 'integer',
            8 => 'integer',
            9 => 'integer',
        ])) {
        }
        else {
            abort(400);
        }
    }

    protected function addFoodToGoodiebag($goodiebag,$foods)
    {
        foreach($foods as $food_id => $amount) {
            $goodiebag->foods()->attach($food_id, ['amount' => $amount]);            
        }
    }
}
