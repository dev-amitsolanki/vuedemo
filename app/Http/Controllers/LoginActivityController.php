<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\LoginActivity;
use App\LoginActivity;
use App\User;
use Auth;
use DB;

class LoginActivityController extends Controller
{
    public function index()
{
    $loginActivities = LoginActivity::select('*')->groupBy('user_id')->paginate(2);

    foreach($loginActivities as $key=>$value){
        $value['email'] = $value->users->email;
        $value['name'] = $value->users->name;
        $value['TotalCount'] = LoginActivity::where('user_id',$value->user_id)->count();
        $value['last_login'] = $value->users->last_login_at;
    }
    return response()->json([
        'data' => $loginActivities,
        'success' => true
    ],200);
}
}
