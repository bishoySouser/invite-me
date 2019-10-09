<?php

use Illuminate\Http\Request;

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
// 'Api\UserController@userTypeShow'
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//users
Route::get('v1/user/list/{id}','Api\UserController@userList');

//meetings
Route::post('v1/meeting','Api\MeetingController@createMeeting');
Route::get('v1/meeting/{id}','Api\MeetingController@receiveMeetings'); //list meeting for one user (id)

//messages
Route::post('v1/message','Api\MessageController@store');

Route::get('v1/message/one={one}/two={two}','Api\MessageController@showChat'); 
