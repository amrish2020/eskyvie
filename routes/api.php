<?php

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

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

Route::apiResources(['user'=>'API\UserController']);
Route::apiResources(['ads'=>'API\AdsController']);
Route::apiResources(['leads'=>'API\LeadsController']);

Route::get('profile','Api\UserController@Profile');
Route::put('profile','Api\UserController@updateProfile');
Route::get('findUser','Api\UserController@search');

Route::get('findLeads','Api\LeadsController@search');
Route::get('findAds','Api\AdsController@search');
Route::get('adslist','Api\AdsController@getAdsList');

Route::get('parentUserList','Api\UserController@GetparentUserList');

