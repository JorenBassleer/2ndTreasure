<?php

namespace App\Http\Controllers;

use App\Goodiebag;
use App\Food;
use App\Foodbank;
use App\FoodGoodiebag;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class GoodiebagController extends Controller
{
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
        $validator = $this->validateGoodiebag($request);
        if(!$validator->passes()) {
            return redirect()->back()
            ->withErrors(['errors'=>$validator->errors()->all()])->withInput();
        }
        $goodiebag = new Goodiebag ([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'foodbank_id' => $request->foodbank_id,

        ]);
        $goodiebag->code = Str::random(5);
        $goodiebag->save();
        // If false there was a submitted amount that wasn't a number
        if(!$this->addFoodToGoodiebag($goodiebag,$request->except('_token', 'foodbank_id'))) {
            $goodiebag->delete();
            return back()->withErrors('You submitted an amount that wasn\'t a number');
        }
        // Check if there is not a user logged in
        // This way if the user creates an account
        // And wants to collect the treasures
        // We can find everything associated with
        // the user
        // Also Create a session so user can access url + qr code
        Session::put('goodiebag_id', $goodiebag->id);
        return redirect()->route('show.code', $goodiebag->id)->with('success_message', 'Goodiebag created');  
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

    protected function validateGoodiebag(Request $request) {
        $validator = Validator::make($request->all(), [
            'water' => 'nullable',
            'fruits' => 'nullable',
            'vegetables' => 'nullable',
            'bread' => 'nullable',
            'dairy' => 'nullable',
            'fish' => 'nullable',
            'meat' => 'nullable',
            'body care' => 'nullable',
           'other' => 'nullable',
           'foodbank_id' => 'required', 
        ],
        ['foodbank_id.required' => 'You have to select a foodbank on the map']);
        if($request->foodbank_id==null) {
            $validator->errors()->add('foodbank_id', 'You have to select a foodbank from the map');
        }
        return $validator;
    }

    protected function addFoodToGoodiebag($goodiebag,$foods)
    {
        if($this->containsOnlyNull($foods)) {
            return false;
        }
        foreach($foods as $food => $amount) {
            // Don't allow null in DB
            if($amount !=null) {
                // Check if submitted amount is a number
                if(!is_numeric($amount)) {
                    return false;
                }
                // Search id of food
                $foodDb = Food::where('type', $food)->first();
                // add id and amount to array -> so we don't create an unsuccessful goodiebag
                $goodiebag->foods()->attach($foodDb->id, ['amount' => $amount]);
                // Get submitted amount of food
                // Get avg food weight if food value isn't submitted in grams
                if($food == 'fish' || $food == 'meat' || $food == 'body_care' || $food == 'other') {
                    // Calculate treasures first since if meat/fish
                    // we convert it to kg
                    $treasures = $this->calculateAction($food, $amount, 'value');
                    // Add to total weight of food weight
                    // Check if meat or fish since submitted amount
                    // is in g
                    if($food == 'fish' || $food == 'meat') {
                        $amount = $amount / 1000;
                    }
                    $goodiebag->treasures += $treasures;
                    $goodiebag->total_kg += $amount;
                }
                else {
                    $foodWeight = $this->calculateAction($food, $amount, 'avgWeightPer');
                    $treasures = $this->calculateAction($food, $amount, 'value');
                    // Add to total weight of food weight
                    $goodiebag->total_kg += $foodWeight;
                    $goodiebag->treasures += $treasures;
                }

            }
        }
        $goodiebag->save();
        return true;
    }

    public function containsOnlyNull($input)
    {
        return empty(array_filter($input, function ($a) { return $a !== null;}));
    }

    protected function calculateAction($foodName, $amount, $action)
    {
        $food = Food::where('type', $foodName)->first();
        // Get the average action
        $actionEach = $food->$action;
        // Multiply with amount submitted
        $actionAmount = $actionEach * $amount;

        return $actionAmount;
    }

}
