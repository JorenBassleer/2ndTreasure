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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Foodbank \\
Route::resource('/foodbank', 'FoodbankController')->middleware('auth');

Route::resource('/goodiebag', 'GoodiebagController');

// Overview of what is in goodiebag + select foodbank
Route::get('/goodiebag/{goodiebag}/select_foodbank', 'GoodiebagController@selectFoodbank')->name('goodiebag.select_foodbank');
Route::post('/goodiebag/{goodiebag}/select_foodbank', 'GoodiebagController@storeSelectedFoodbank')->name('goodiebag.store_selected_foodbank');