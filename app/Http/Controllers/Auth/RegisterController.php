<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postalcode' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $address = $data['address'] . " " . $data['postalcode']. " " . $data['city']. " " . $data['province']. " " . $data['country'];
        $latLng = $this->get_lat_long($address);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'city' => $data['city'],
            'postalcode' => $data['postalcode'],
            'province' => $data['province'],
            'country' => $data['country'],
            'phone' => $data['phone'],
            'lat' => $latLng[0],
            'lng' => $latLng[1],
            'password' => Hash::make($data['password']),
        ]);
    }

        // function to get  the address
   public function get_lat_long($address){

    // Get lat and long by address         
    $prepAddr = str_replace(' ','+',$address);
    $apikey = env('GOOGLE_APIKEY');
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
