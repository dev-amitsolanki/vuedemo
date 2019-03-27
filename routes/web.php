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
    return view('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/getitems', 'MemberController@getdata');
Route::get('/getmember', 'MemberController@getdata');
Route::get('/getuser', 'MemberController@getuser');
// Route::post('/logout','MemberController@logout');



