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
use App\Traits\LatLngTrait;
use App\Traits\CaptchaTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\FoodbankApplicationMail;
use App\Mail\FoodbankApplicationReplyMail;
use Config;
use Storage;

class FoodbankController extends Controller
{
    use LatLngTrait, CaptchaTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('foodbank.index')->with([
            'foodbanks' => User::onlyFoodbanks()->paginate(),
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

    // Apply to be introduced to website
    public function showForm()
    {
        return view('foodbank.form');
    }
    // Post form from above
    public function postForm(Request $request)
    {
        // Validate form
        $validator = $this->validateFoodbankForm($request);

        if(!$validator->passes()) {
            return redirect()->back()
            ->withErrors(['errors'=>$validator->errors()->all()])->withInput();
        }
        // Validate captcha
        $result = $this->checkCaptcha($request['g-recaptcha-response']);
        if(!$result['success']) {
            return back()->withErrors('Captcha failed');
        }
        try {
            // Mail to me
            Mail::to(config('mail.from.address'))
            ->send(new FoodbankApplicationMail($request->except('_token', 'g-recapthca-response')));
            Mail::to($request->foodbank_email)
            ->send(new FoodbankApplicationReplyMail($request->except('_token', 'g-recapthca-response')));
        } catch(Exception $e) {
            return back()->withErrors($e);
        }
        return back()->with('success_message', 'Application has been send');
    }
    /**+
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
        // Check if id = foodbank
        if(!$foodbank->isFoodbank) {
            // Send user to 404 if not found
            return abort(404);
        }
        // Get style of google maps
        $json = Storage::disk('local')->get('json/map-style.json');
        $json = json_decode($json, true);
        // Is the same one as the one displayed
        // Since foodbanks are users
        // We first need to get foodbank information
        return view('foodbank.show')->with([
            'foodbank' => $foodbank,
            'isLoggedIn' => $isLoggedIn,
            'styledMap' => $json,
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
        $latLng = $this->getLatLng($address);
        $foodbank->lat = $latLng[0];
        $foodbank->lng = $latLng[1];
        $foodbank->save();
        $foodbank->foodbank->save();
        return redirect()->route('foodbank.show', $foodbank->id)->with('success_message', 'Foodbank updated')->withInput();
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
        ],
        [
            'foodbank_name.required' => 'Name field is required',
            'foodbank_email.required' => 'Email field is required',
            'foodbank_address.required' => 'Address field is required',
            'foodbank_city.required' => 'City field is required',
            'foodbank_postalcode.required' => 'Postalcode field is required',
            'foodbank_province.required' => 'Province field is required',
            'foodbank_country.required' => 'Country field is required',
            'foodbank_phone.required' => 'Phone field is required',
        ]);
        return $validator;
    }
}
