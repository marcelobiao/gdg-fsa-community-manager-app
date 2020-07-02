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

Route::prefix('admin/')->namespace('Admin')->group(function(){
    Route::prefix('events/')->group(function(){
        Route::get("/", "EventController@index");
        Route::get("{id}/", "EventController@show");
        Route::post("/", "EventController@store");
        Route::put("{id}/", "EventController@update");
        Route::delete("{id}/", "EventController@destroy");
    });

});
