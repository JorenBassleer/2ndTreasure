<?php

namespace App\Http\Controllers;

use App\Goodiebag;
use App\Food;
use App\Foodbank;
use App\FoodGoodiebag;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Traits\CaptchaTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Storage;
class GoodiebagController extends Controller
{
    use CaptchaTrait;
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

        return view('welcome')->with([
            'foods' => Food::all(),
            'foodbanks' => User::where('isFoodbank', true)
                                    ->whereNotNull(['lat','lng'])->get(),
            'lat' => 51.2194475,
            'lng' => 4.4024643,
            'styledMap' => $json,
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
        // Validate captcha
        $result = $this->checkCaptcha($request['g-recaptcha-response']);
        if(!$result['success']) {
            return back()->withErrors('Captcha failed');
        }
        $goodiebag = new Goodiebag ([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'foodbank_id' => $request->foodbank_id,

        ]);
        $goodiebag->code = Str::random(5);
        $goodiebag->save();
        // If false there was a submitted amount that wasn't a number
        if(!$this->addFoodToGoodiebag($goodiebag,$request->except('_token', 'foodbank_id','g-recaptcha-response'))) {
            $goodiebag->delete();
            return back()->withErrors('You submitted an amount that wasn\'t a number');
        }
        if(Auth::check()) {
            return redirect()->route('show.code', $goodiebag->id)->with('success_message', 'Goodiebag created');
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
           'g-recaptcha-response' => 'required', 
        ],
        // Message if foodbank_id wasn't submitted
        [
            'foodbank_id.required' => 'You have to select a foodbank on the map',
            'g-recaptcha-response.required' => 'Captcha failed',
        ]);
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
