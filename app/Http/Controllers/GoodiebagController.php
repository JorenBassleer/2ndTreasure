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
        return redirect()->route('goodiebag.select_foodbank', $goodiebag->id);
        
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
    public function selectFoodbank(Goodiebag $goodiebag)
    {
        // Check if logged in user is the one who created the goodiebag
        if($goodiebag->user_id == auth()->user()->id) {
            // Don't allow goodiebags with nothing in
            if(count($goodiebag->foods) != 0) {
                return view('goodiebag.select_foodbank')->with([
                'goodiebag'=>$goodiebag,
                'foodbanks' => Foodbank::all(),
                ]);
            }
            else {
                // Delete goodiebag if it doesn't contain any food
                $goodiebag->delete();
                return back()->withErrors('error', 'Goodiebag can\'t be empty');
            }

        }
        else {
            abort(403);
        }

    }
    public function storeSelectedFoodbank(Goodiebag $goodiebag, Request $request)
    {
        $this->validateFoodbank($request);
        $foodbank_id = Foodbank::where('foodbank_name', $request->foodbank_name)->first()->id;
        if( $foodbank_id != null) {
            // Link goodiebag with posted foodbank
            $goodiebag->foodbank_id = $foodbank_id;
            // Set status to pending
            $goodiebag->status_id = 2;
            $goodiebag->save();
            return view('thankyou')->with(['goodiebag' => $goodiebag,
                                            'foodbank' => Foodbank::find($foodbank_id), 
                                            ]);
        }
    }

    protected function validateGoodiebag(Request $request) {
        dd($request->except('_token'));
        if($request->validate([
            ['1' => 'numeric'],
            ['2' => 'min:0'],
            ['3' => 'min:0'],
            ['4' => 'min:0'],
            ['5' => 'min:0'],
            ['6' => 'min:0'],
            ['7' => 'min:0'],
            ['8' => 'min:0'],
            ['9' => 'min:0'],
        ])) {
        }
        else {
            abort(400);
        }
    }

    protected function addFoodToGoodiebag($goodiebag,$foods)
    {
        foreach($foods as $food_id => $amount) {
            // Don't allow null in DB
            if($amount!=null) {
                $goodiebag->foods()->attach($food_id, ['amount' => $amount]);            
            }
        }
    }

    protected function validateFoodbank($request)
    {
        if($request->validate([
            'foodbank_name' => 'string|exists:foodbanks,foodbank_name',
        ])) {
        }
        else {
            abort(400);
        }
    }
}
