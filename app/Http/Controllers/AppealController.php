<?php

namespace App\Http\Controllers;

use App\Appeal;
use App\User;
use App\Foodbank;
use App\Goodiebag;
use Validator;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is not connected with a foodbank
        if(!count(auth()->user()->foodbanks) > 0) {
            // Get all appeals from user
            $appeals = Appeal::where('user_id', auth()->user()->id)->get();
            $this->changeHasRead('user_id', auth()->user()->id,1, 1);
            return view('appeal.index')->with('user_appeals', $appeals);
        }

        // Get all Foodbanks that are linked with logged in user
        // And is allowed to see the appealss
        $foodbanks = Foodbank::whereHas('users', function ($query) {
            return $query->where([
                ['user_id', '=', auth()->user()->id],
                ['role_id', '<', 6],
                ]);
        })->get();

        foreach($foodbanks as $foodbank) {
            $this->changeHasRead('foodbank_id',$foodbank->id,1,0);
            
        }
        $this->changeHasRead('user_id', auth()->user()->id,1,1);

        return view('appeal.index')->with([
            'foodbanks' => $foodbanks,
            'user_appeals' => Appeal::where('user_id', auth()->user()->id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $foodbank = Foodbank::where('foodbank_name', $request->foodbank_name)->first();
        // Invalid foodbank requested
        if($foodbank == null) {
            return back()->withErrors('That foodbank wasn\'t found in our records');
        }
        $appeal = new Appeal;
        $appeal->foodbank_id = $foodbank->id;
        $appeal->user_id = auth()->user()->id;
        $appeal->goodiebag_id = $request->goodiebag_id;
        $appeal->status_id = 2;
        $appeal->save();
        return view('thankyou')->with(['goodiebag' => Goodiebag::find($request->goodiebag_id),
                                        'foodbank' => $foodbank, 
                                        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appeal  $appeal
     * @return \Illuminate\Http\Response
     */
    public function show(Appeal $appeal)
    {
        // Check if foodbank checks appeal or user
        // User is the one who created the appeal
        if($appeal->user_id == auth()->user()->id) {
            return view('appeal.show')->with([
                'appeal' => $appeal,
                'isFoodbankOwner' => false,
                ]);
        }
        // Check if user is connected with relevant foodbank
        foreach(auth()->user()->foodbanks as $foodbank) {
            if($appeal->foodbank_id == $foodbank->id) {
                return view('appeal.show')->with([
                    'appeal' => $appeal,
                    'isFoodbankOwner' => true,
                    ]);
            }
        }
        return back()->withErrors('Unauthorized');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appeal  $appeal
     * @return \Illuminate\Http\Response
     */
    public function edit(Appeal $appeal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appeal  $appeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appeal $appeal)
    {
        //
    }

    public function changeStatus(Request $request, Appeal $appeal)
    {
        // Check if none is submitted
        if($request->status==null) {
            return back()->withErrors('Bad request');
        }
        // Change status
        $appeal->status_id = $request->status;
        // Change appeal to unread so user sees his request is updated
        $appeal->hasUserRead = 0;
        $appeal->save();

        return redirect()->route('appeal.index')->with('success_message', $request->status == 1 ? 'Goodiebag accepted' : 'Goodiebag denied');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appeal  $appeal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appeal $appeal)
    {
        //
    }

    protected function validateFoodbank($request)
    {
        $validator = Validator::make($request->all(), [
            ['foodbank_name' => 'string|exists:foodbanks,foodbank_name'],
            ['goodiebag_id' => 'integer|exists:goodiebags,id'],
        ]);
        return $validator;
    }
    protected function changeHasRead($columnName,$id,$hasRead,$isUser)
    {
        $appealRow = Appeal::where($columnName, $id)->get();
        if($isUser) {
            if(!$hasRead) {
                $appealRow->map(function($row){
                    $row->hasUserRead=0;
                    $row->save();
                });
            } else {
                $appealRow->map(function($row){
                    $row->hasUserRead=1;
                    $row->save();
                });
            }
        } else {
            if(!$hasRead) {
                $appealRow->map(function($row){
                    $row->hasFoodbankRead=0;
                    $row->save();
                });
            } else {
                $appealRow->map(function($row){
                    $row->hasFoodbankRead=1;
                    $row->save();
                });
            }
        }

    }
}
