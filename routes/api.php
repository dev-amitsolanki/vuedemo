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

// Route::middleware('auth:api')->get('/register', function (Request $request) {
    // return $request->user();
// });
Route::post('login', 'Login\LoginController@login');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'MemberController@logout');
    Route::get('/getitems', 'MemberController@getdata');
    Route::get('/getmember', 'MemberController@getdata');
    Route::get('/getuser', 'MemberController@getuser');
    Route::post('register', 'MemberController@store');
    Route::put('edit/{id}', 'MemberController@update');
    Route::delete('delete/{id}', 'MemberController@destroy');
    Route::get('data', 'MemberController@userData');
    Route::post('m-charge', 'MaintenanceController@addcharge');
    Route::post('m-data', 'MaintenanceController@Mntdata');
    Route::post('mainteCal', 'MaintenanceController@calcuMaint');
    Route::post('addblock', 'GeneralSettingController@addblock');
    Route::get('getBlock', 'GeneralSettingController@getBlock');
    Route::delete('deleteBlock/{id}', 'GeneralSettingController@deleteBlock');
    Route::post('addFlatType', 'GeneralSettingController@addFlatType');
    Route::get('getflatType', 'GeneralSettingController@getFlatType');
    Route::delete('deleteFlatType/{id}', 'GeneralSettingController@deleteFlatType');
    Route::get('/login-activity', 'LoginActivityController@index');
    Route::post('/createComplain', 'ComplainController@addComplain');
    Route::get('/getcomplain', 'ComplainController@getComplain');
    Route::put('submitResolution/{id}', 'ComplainController@resolution');
    Route::delete('deleteComplain/{id}', 'ComplainController@deleteComplain');
    //member side get complain data
    Route::get('complainData', 'ComplainController@complainData');
    //admin notice
    Route::post('newNotice', 'NoticeController@create');
    Route::get('getnotice', 'NoticeController@getnotice');
    Route::put('status/{id}', 'NoticeController@updateStatus');
    //member notice
    Route::get('NoticeGet', 'NoticeController@NoticeGet');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});


