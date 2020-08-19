<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    // $map = json_decode(\GoogleMaps::load('geocoding')
    //             ->setParam (['address' =>'antwerpen'])
    // //             ->get());
    // $antwerpLat = $map->results[0]->geometry->location->lat;
    // $antwerpLng = $map->results[0]->geometry->location->lng;
    // dd($map);
    // $map = \GoogleMaps::create_map();
    return view('welcome')->with([
        'foods' => App\Food::all(),
        'foodbanks' => App\User::where('isFoodbank', true)
                                ->whereNotNull(['lat','lng'])->get(),
        'lat' => 51.2194475,
        'lng' => 4.4024643,
    ]);
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Foodbank \\
Route::resource('/foodbank', 'FoodbankController');

// Route::post('/foodbank', 'Auth\AuthController@foodbankLogin');
Route::resource('/goodiebag', 'GoodiebagController');

// Overview of what is in goodiebag + select foodbank
Route::get('/goodiebag/{goodiebag}/select_foodbank', 'GoodiebagController@selectFoodbank')->name('goodiebag.select_foodbank');

Route::resource('/appeal', 'AppealController')->middleware('auth');
Route::post('/appeal/{appeal}/change_status', 'AppealController@changeStatus')->middleware('auth')->name('appeal.changeStatus');
Route::get('cron/clean', 'CronController@cleanDatabase');
// Users
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
});

// Only foodbanks allowed
Route::group(['middleware' => ['auth', 'foodbank']], function () {
    Route::get('/code/confirm', 'CodeController@showConfirm')->name('show.confirm_code');
    Route::get('/code/{code}/confirm', 'CodeController@qrConfirm')->name('code.qr_confirmed');
    Route::post('/code/confirm', 'CodeController@confirm')->name('code.confirmed'); 
});

Route::get('/goodiebag/{goodiebag}/delivered', 'CodeController@checkIfDelivered')->name('code.check_if_delivered');
Route::get('/code/{goodiebag}', 'CodeController@show')->name('show.code');
