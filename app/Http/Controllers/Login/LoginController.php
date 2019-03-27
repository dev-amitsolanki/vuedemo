<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;

class LoginController extends Controller
{
    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);
    $user = DB::table('users')->where('email', $request->get('email'))->first();
    // dd($user);
            if($user != null ){
                if(!\Hash::check($request->get('password'),$user->password)){
                    return response()->json([
                        'message' => 'password is wrong',
                        'data' => '',
                        'success' => false,
                    ],500);
                }
            }else{
                return response()->json([
                    'message' => 'user not found',
                    'data' => '',
                    'success' => false,
                ],500);
            }
            if(Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])){

                $users = DB::table('users')
                     ->select('*')
                     ->where('email',$request->get('email'))
                     ->first();
                $user = Auth::user();
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                return response()->json([
                    'message' => 'You are logging in!',
                    'data' => $users,
                    'accessToken'   => $success['token'],
                    'success' => true,
                ],200);
            }
    }
}
