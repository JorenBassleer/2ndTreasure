<?php

use Illuminate\Support\Facades\Route;
use App\Mail\FoodbankApplicationMail;
use App\Mail\ForFlaggedUsersMail;
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



// Foodbank \\
Route::get('/foodbank/form', 'FoodbankController@showForm')->name('foodbank.show_form');
Route::post('/foodbank/form', 'FoodbankController@postForm')->name('foodbank.post_form');
Route::resource('/foodbank', 'FoodbankController')->only([
    'index', 'show', 'create'
]);

Route::resource('/goodiebag', 'GoodiebagController')->only([
    'destroy', 'store', 'create'
]);

// Users
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::get('/leaderboard', 'LeaderBoardController@index')->name('leaderboard.index');

});

// Only foodbanks allowed
Route::group(['middleware' => ['auth', 'foodbank']], function () {
    Route::get('/code/{code}/confirm', 'CodeController@qrConfirm')->name('code.qr_confirmed');
    Route::post('/code/confirm', 'CodeController@confirm')->name('code.confirmed');
    
    Route::resource('/foodbank', 'FoodbankController')->only([
        'update'
    ]);
});

Route::get('/goodiebag/{goodiebag}/delivered', 'CodeController@checkIfDelivered')->name('code.check_if_delivered');
Route::get('/code/{goodiebag}', 'CodeController@show')->name('show.code');
