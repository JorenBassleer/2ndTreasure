<?php

namespace App\Http\Controllers;

use App\Foodbank;
use App\FoodbankUser;
use Illuminate\Http\Request;
use Validator;
class FoodbankController extends Controller
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
        return view('foodbank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateFoodbank($request);
        if(!$validator->passes()) {
            return redirect()->back()
            ->withErrors(['errors'=>$validator->errors()->all()])->withInput();
        }
        $foodbank = new Foodbank;
        $hasSucceeded = $foodbank->fill($request->all());
        $foodbank->save();
        $foodbank->users()->attach(auth()->user()->id);
        $changeRole = FoodbankUser::where([['user_id', auth()->user()->id],
                            ['foodbank_id', $foodbank->id],              
        ])->first();
        $changeRole->role_id = 1;
        $changeRole->save();
        return redirect('home')->with('success_message', 'Foodbank added')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Foodbank  $foodbank
     * @return \Illuminate\Http\Response
     */
    public function show(Foodbank $foodbank)
    {
        return view('foodbank.show')->with('foodbank', $foodbank);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Foodbank  $foodbank
     * @return \Illuminate\Http\Response
     */
    public function edit(Foodbank $foodbank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Foodbank  $foodbank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Foodbank $foodbank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Foodbank  $foodbank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Foodbank $foodbank)
    {
        //
    }

    protected function validateFoodbank(Request $request) {
        $validator = Validator::make($request->all(), [
            'foodbank_name' => 'required|max:100|string',
            'foodbank_email' => 'required|max:100|string|unique:foodbanks,foodbank_email',
            'foodbank_address' => 'required|max:100|string',
            'foodbank_city' => 'required|max:100|string',
            'foodbank_postalcode' => 'required|max:100|string',
            'foodbank_province' => 'required|max:100|string',
            'foodbank_phone' => 'required|max:100|string',
            'company_number' => 'required|max:100|string',
            'details' => 'required|max:255|string',
        ]);
        return $validator;
    }

}
