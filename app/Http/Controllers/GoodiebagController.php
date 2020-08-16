<?php

namespace App\Http\Controllers;

use App\Goodiebag;
use App\Food;
use App\Foodbank;
use App\FoodGoodiebag;
use Illuminate\Http\Request;
use Validator;
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
        $validator =$this->validateGoodiebag($request);
        if(!$validator->passes()) {
            return redirect()->back()
            ->withErrors(['errors'=>$validator->errors()->all()])->withInput(); }
        $goodiebag = new Goodiebag ([
            'user_id' => auth()->user()->id,
        ]);
        $goodiebag->save();
        // If false there was a submitted amount that wasn't a number
        if(!$this->addFoodToGoodiebag($goodiebag,$request->except('_token'))) {
            $goodiebag->delete();
            return back()->withErrors('You submitted an amount that wasn\'t a number');
        }
        // Foodbanks in the area of user maybe
        return redirect()->route('goodiebag.select_foodbank', $goodiebag->id)->with('success_message', 'Goodiebag created');
        
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
        if($goodiebag->user_id != auth()->user()->id) {
            return back()->withErrors('Unauthorized');
        }
       
        // Don't allow goodiebags with nothing in
        if(count($goodiebag->foods) == 0) {
            // Delete goodiebag if it doesn't contain any food
            $goodiebag->delete();
            return back()->withErrors('Goodiebag can\'t be empty');

        }
        return view('goodiebag.select_foodbank')->with([
            'goodiebag'=>$goodiebag,
            'foodbanks' => Foodbank::all(),
            ]);

    }
    public function storeSelectedFoodbank(Goodiebag $goodiebag, Request $request)
    {
        $this->validateFoodbank($request);
        $foodbank_id = Foodbank::where('foodbank_name', $request->foodbank_name)->first()->id;
        // Invalid foodbank requested
        if($foodbank_id == null) {
            return back()->withErrors('That foodbank wasn\'t found in our records');
        }
        // Link goodiebag with posted foodbank
        $goodiebag->foodbank_id = $foodbank_id;
        // Set status to pending
        $goodiebag->status_id = 2;
        $goodiebag->save();
        return view('thankyou')->with(['goodiebag' => $goodiebag,
                                        'foodbank' => Foodbank::find($foodbank_id), 
                                        ]);
    }

    protected function validateGoodiebag(Request $request) {
        $validator = Validator::make($request->all(), [
            ['Water' => 'nullable'],
            ['fruits' => 'nullable'],
            ['vegetables' => 'nullable'],
            ['bread' => 'nullable'],
            ['dairy' => 'nullable'],
            ['fish' => 'nullable'],
            ['meat' => 'nullable'],
            ['body care' => 'nullable'],
           ['other' => 'nullable'],
        ]);
        return $validator;
    }

    protected function addFoodToGoodiebag($goodiebag,$foods)
    {
        foreach($foods as $food => $amount) {
            // Don't allow null in DB
            if($amount !=null) {
                // Check if submitted amount is a number
                if(!is_numeric($amount)) {
                    return false;
                }
                // Search id of food
                $food_id = Food::where('type', $food)->first()->id;
                // add id and amount to array -> so we don't create an unsuccessful goodiebag
                $goodiebag->foods()->attach($food_id, ['amount' => $amount]);
            }
        }
        return true;
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
