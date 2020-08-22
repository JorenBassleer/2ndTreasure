<?php

namespace App\Http\Controllers;

use App\Foodbank;
use App\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\UserInterface;
use Illuminate\Support\Facades\Auth;
class FoodbankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('foodbank.index')->with([
            'foodbanks' => User::where('isFoodbank', 1)->paginate(),
        ]);
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

    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateFoodbankRegister($request);
        if(!$validator->passes()) {
            return redirect()->back()
            ->withErrors(['errors'=>$validator->errors()->all()])->withInput();
        }
        $foodbankAcc = User::create([
            'name' => $request->foodbank_name,
            'email' =>  $request->foodbank_email,
            'address' => $request->foodbank_address ,
            'city' => $request->foodbank_city,
            'postalcode' => $request->foodbank_postalcode,
            'province' => $request->foodbank_province ,
            'country' => $request->foodbank_country,
            'phone' => $request->foodbank_phone ,
            'isFoodbank' => true,
            'password' => Hash::make($request->password),
        ]);
        $address = $foodbankAcc->address . " " . $foodbankAcc->postalcode . " " . $foodbankAcc->city . " " . $foodbankAcc->province. " " . $foodbankAcc->country;
        $latLng = $this->get_lat_long($address);
        $foodbankAcc->lat = $latLng[0];
        $foodbankAcc->lng = $latLng[1];
        $foodbankAcc->save();
        Foodbank::create([
            'user_id' => $foodbankAcc->id,
            'company_number' => $request->company_number,
            'details' => $request->details,
        ]);
        Auth::login($foodbankAcc);

        return redirect('home')->with('success_message', 'Foodbank added')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Foodbank  $foodbank
     * @return \Illuminate\Http\Response
     */
    public function show(User $foodbank)
    {
        // Check if logged in foodbank
        if(Auth::check()) {
            $isLoggedIn = auth()->user()->id == $foodbank->id ? 1 : 0;
        }
        else {
            $isLoggedIn = 0;
        }
        // Is the same one as the one displayed
        // Since foodbanks are users
        // We first need to get foodbank information
        return view('foodbank.show')->with([
            'foodbank' => $foodbank,
            'isLoggedIn' => $isLoggedIn,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Foodbank  $foodbank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $foodbank)
    {
        $validator = $this->validateFoodbankForm($request);
        if(!$validator->passes()) {
            return redirect()->back()
            ->withErrors(['errors'=>$validator->errors()->all()])->withInput();
        }
        $foodbank->name= $request->foodbank_name;
        $foodbank->email=  $request->foodbank_email;
        $foodbank->address= $request->foodbank_address ;
        $foodbank->city= $request->foodbank_city;
        $foodbank->postalcode= $request->foodbank_postalcode;
        $foodbank->province= $request->foodbank_province ;
        $foodbank->country= $request->foodbank_country;
        $foodbank->phone= $request->foodbank_phone;

        $foodbank->foodbank->details = $request->details;
        $foodbank->foodbank->company_number = $request->company_number;

        $address = $foodbank->address . " " . $foodbank->postalcode . " " . $foodbank->city . " " . $foodbank->province. " " . $foodbank->country;
        $latLng = $this->get_lat_long($address);
        $foodbank->lat = $latLng[0];
        $foodbank->lng = $latLng[1];
        $foodbank->save();
        $foodbank->foodbank->save();
        return redirect()->route('foodbank.show', $foodbank->id)->with('success_message', 'Foodbank updated')->withInput();
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

    protected function validateFoodbankRegister(Request $request) {
        $validator = Validator::make($request->all(), [
            'foodbank_name' => 'required|max:100|string',
            'foodbank_email' => 'required|max:100|string|unique:users,email',
            'foodbank_address' => 'required|max:100|string',
            'foodbank_city' => 'required|max:100|string',
            'foodbank_postalcode' => 'required|max:100|string',
            'foodbank_province' => 'required|max:100|string',
            'foodbank_country' => 'required|max:100|string',
            'foodbank_phone' => 'required|max:100|string',
            'company_number' => 'required|max:100|string',
            'details' => 'required|max:255|string',
            'password' => 'required', 'string', 'min:8', 'confirmed',
        ]);
        return $validator;
    }

    protected function validateFoodbankForm(Request $request) {
        $validator = Validator::make($request->all(), [
            'foodbank_name' => 'required|max:100|string',
            'foodbank_email' => 'required|max:100|string',
            'foodbank_address' => 'required|max:100|string',
            'foodbank_city' => 'required|max:100|string',
            'foodbank_postalcode' => 'required|max:100|string',
            'foodbank_province' => 'required|max:100|string',
            'foodbank_country' => 'required|max:100|string',
            'foodbank_phone' => 'required|max:100|string',
            'company_number' => 'max:100|string',
            'details' => 'max:255|string',
        ]);
        return $validator;
    }

    // function to get  the address
   public function get_lat_long($address){

     // Get lat and long by address         
     $prepAddr = str_replace(' ','+',$address);
     $apikey = "AIzaSyAXVSQngRh511t5sFYqGlveekKmHBda-ow";
     $geocode=$this->file_get_content_curl('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key='.$apikey);
     $output= json_decode($geocode);
     $LatLon[0] = $output->results[0]->geometry->location->lat;
     $LatLon[1] = $output->results[0]->geometry->location->lng;
     return $LatLon;
    }

    public function file_get_content_curl ($url) 
    {
        // Throw Error if the curl function does'nt exist.
        if (!function_exists('curl_init'))
        { 
            die('CURL is not installed!');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
