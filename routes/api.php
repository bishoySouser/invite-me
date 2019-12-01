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
Route::post('v1/meeting','Api\MeetingController@createMeeting'); //create New Meeting
Route::get('v1/meeting/{id}','Api\MeetingController@receiveMeetings'); //Meetings list for one user (id)
Route::delete('v1/meeting/{id}','Api\MeetingController@deleteMeeting'); //Delete meeting one (id)
Route::put('v1/meeting','Api\MeetingController@MeetingEditStatus'); //Edit Meeting Status (Approved)
Route::put('v1/meeting/status','Api\MeetingController@changeTimeMeeting'); //Edit Meeting Status (change time)

Route::get('v1/meeting/approved/{id}','Api\MeetingController@aprrovedMeetings'); //Meetings list for one user (id)

Route::get('v1/meeting/{owner}/{invitee}/{date?}','Api\MeetingController@meetingBook');//get meeting book

//messages
Route::post('v1/message','Api\MessageController@store');
Route::get('v1/message/one={one}/two={two}','Api\MessageController@showChat');

//event
Route::get('v1/event', 'Api\AdminController@eventInfo');
Route::post('v1/event/date', 'Api\AdminController@addEventDate'); //add new date for event
Route::delete('v1/event/date/{id}','Api\AdminController@deleteEventDate'); //Delete event date (id)
Route::put('v1/event','Api\AdminController@editEventInfo'); //Edit event

//count users and meeting , uam = user and meeting 
Route::get('v1/info/uam', 'Api\AdminController@uamInfo');

Route::post('v1/meeting/admin/userAdd', 'Api\AdminController@useradd');//add admin
Route::get('v1/admin/usersList', 'Api\AdminController@usersList');//get users list
Route::get('v1/admin/meetings', 'Api\AdminController@getMeetings');//get meetings
Route::get('v1/admin/infoMeeting', 'Api\AdminController@infoMeeting');//get users list
Route::delete('v1/admin/user/{id}', 'Api\AdminController@deleteUser');//delete User

Route::get('v1/admin/statusCount', 'Api\AdminController@statusCount');//get count status

Route::post('v1/user/uploadProfilePicture', 'Api\UserController@uploadProfilePicture');
Route::post('v1/user/uploadInformation', 'Api\UserController@uploadInformation');

Route::post('v1/user/changePassword' , 'Api\UserController@changePassword');

Route::post('v1/user/login', 'Api\UserController@login'); // api login