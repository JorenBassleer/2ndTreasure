<?php

use Illuminate\Support\Facades\Route;
use App\Mail\FoodbankApplicationMail;
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

Route::get('/', 'LandingPageController@displayLandingPage')->name('landing');


Auth::routes();

Route::get('/email',function() {
    return new FoodbankApplicationMail();
});

// Route::get('/home', 'HomeController@index')->name('home');

// Foodbank \\
Route::get('/foodbank/form', 'FoodbankController@showForm')->name('show.form_foodbank');
Route::post('/foodbank/form', 'FoodbankController@postForm')->name('post.form_foodbank');
Route::resource('/foodbank', 'FoodbankController')->only([
    'index', 'show', 'create'
]);

Route::resource('/goodiebag', 'GoodiebagController');

Route::get('/leaderboard', 'LeaderBoardController@index')->name('leaderboard.index');
Route::get('cron/clean', 'CronController@cleanDatabase');
Route::get('cron/testing', 'CronController@testing');

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

Route::get('/cookie/destroy', 'CookieController@destroyCookie');