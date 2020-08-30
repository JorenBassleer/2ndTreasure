<?php

namespace App\Http\Controllers;

use App\Goodiebag;
use App\Food;
use App\Foodbank;
use App\FoodGoodiebag;
use Illuminate\Http\Request;
use Validator;
use Config;
use App\User;
use App\Traits\AddFoodToGoodiebagTrait;
use App\Traits\CaptchaTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Storage;
class GoodiebagController extends Controller
{
    use CaptchaTrait, AddFoodToGoodiebagTrait;
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get style of google maps
        $json = Storage::disk('local')->get('json/map-style.json');
        $json = json_decode($json, true);

        return view('goodiebag.create')->with([
            'foods' => Food::all(),
            'foodbanks' => User::where('isFoodbank', true)
                                    ->whereNotNull(['lat','lng'])->get(),
            'lat' => 51.2194475,
            'lng' => 4.4024643,
            'styledMap' => $json,
        ])->withCookie(cookie('test', 'idk'));
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
        $goodiebag->code = Str::upper($goodiebag->code);
        $goodiebag->save();
        // If false there was a submitted amount that wasn't a number
        if(!$this->addFoodToGoodiebag($goodiebag,$request->except('_token', 'foodbank_id'))) {
            $goodiebag->delete();
            return back()->withErrors('You submitted an amount that wasn\'t valid.')->withInput();
        }
        if(Auth::check()) {
            return redirect()->route('show.code', $goodiebag->id);
        }
;
        // Create cookie if user is not logged in
        // So user can access the page with qr-code
        // 10080 minutes = a week
        $minutes = 10080;
        return redirect()->route('show.code', $goodiebag->id)->with('success_message' ,'Goodiebag created')->withCookie(cookie('goodiebag_id',$goodiebag->id, $minutes));  
    }
    public function destroy(Goodiebag $goodiebag)
    {
        if(!$goodiebag->delete()) {
            return redirect()->route('code.show', $goodiebag->id)->withErrors('Something went wrong while deleting your goodiebag, try again in a few moments');
        }
        Cookie::queue(Cookie::forget('goodiebag_id'));
        return redirect()->route('goodiebag.create')->with('success_message', 'Goodiebag deleted');
    }


    protected function validateGoodiebag(Request $request) {
        $validator = Validator::make($request->all(), [
            'water' => 'numeric|max:50',
            'fruits' => 'numeric|max:50',
            'vegetables' => 'numeric|max:50',
            'bread' => 'numeric|max:50',
            'dairy' => 'numeric|max:50',
            'fish' => 'numeric|max:10000',
            'meat' => 'numeric|max:10000',
            'body care' => 'numeric|max:50',
           'other' => 'numeric|max:50',
           'foodbank_id' => 'required',
        ],
        // Messages
        [
            'foodbank_id.required' => 'You have to select a foodbank on the map',
            'water.max' => 'Water can\'t have a value greater than 50l',
            'fruits.max' => 'Fruits can\'t have a value greater than 50',
            'vegetables.max' => 'Vegetables can\'t have a value greater than 50',
            'bread.max' => 'Bread can\'t have a value greater than 50 l',
            'dairy.max' => 'Dairy can\'t have a value greater than 50',
            'fish.max' => 'Fish can\'t have a value greater than 10kg',
            'meat.max' => 'Meat can\'t have a value greater than 10kg',
            'body care.max' => 'Body care can\'t have a value greater than 50 bottles',
        ]);
        return $validator;
    }

}
