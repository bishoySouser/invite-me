<?php

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

Route::get('/home',[
    'middleware' => 'admin', 
    'uses'=>'HomeController@index'
])->name('home');

Route::get('/profile', function(){
    return view('pages.profile');
})->name('profile')->middleware('auth');;
// meeting
Route::get('/meeting/{staus?}', function () {
    return view('pages.meeting');
})->name('meeting')->middleware('auth');

// admin
Route::get('/admin/{category?}', function () {
    if(Auth::user()->user_type !== 'Admin'){
        return redirect()->back();
    }
    return view('admin.home');
})->name('admin')->middleware('auth');


