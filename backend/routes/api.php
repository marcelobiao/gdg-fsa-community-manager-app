<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login');

Route::post('/logout', 'AuthController@logout');

Route::prefix('admin/')->namespace('Admin')->middleware('jwt.auth')->group(function(){
    Route::prefix('events/')->group(function(){
        Route::get("/", "EventController@index");
        Route::get("{id}/", "EventController@show");
        Route::post("/", "EventController@store");
        Route::put("{id}/", "EventController@update");
        Route::delete("{id}/", "EventController@destroy");
    });
    Route::prefix('people/')->group(function(){
        Route::get("/", "PeopleController@index");
        Route::get("{id}/", "PeopleController@show");
        Route::post("/", "PeopleController@store");
        Route::put("{id}/", "PeopleController@update");
        Route::delete("{id}/", "PeopleController@destroy");
    });
    Route::prefix('peopleEvents/')->group(function(){
        Route::get("/", "PeopleEventController@index");
        Route::get("{id}/", "PeopleEventController@show");
        Route::post("/", "PeopleEventController@store");
        Route::put("{id}/", "PeopleEventController@update");
        Route::delete("{id}/", "PeopleEventController@destroy");
    });
    Route::prefix('imports/')->group(function(){
        Route::get("/", "ImportController@index");
        Route::get("{id}/", "ImportController@show");
        Route::post("/", "ImportController@store");
        Route::put("{id}/", "ImportController@update");
        Route::delete("{id}/", "ImportController@destroy");
        Route::post("/manualCheckIn/", "ImportController@manualCheckIn");
    });
});
