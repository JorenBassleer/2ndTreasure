<?php

namespace App\Http\Controllers;

use App\Goodiebag;
use App\Food;
use App\Foodbank;
use App\FoodGoodiebag;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
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
        // Foodbanks in the area of user maybe
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

    public function confirmGoodiebag(Goodiebag $goodiebag)
    {
        # code...
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
                $food_id = Food::where('type', $food)->first()->id;
                // add id and amount to array -> so we don't create an unsuccessful goodiebag
                $goodiebag->foods()->attach($food_id, ['amount' => $amount]);
            }
        }
        return true;
    }

    public function containsOnlyNull($input)
    {
        return empty(array_filter($input, function ($a) { return $a !== null;}));
    }
}
