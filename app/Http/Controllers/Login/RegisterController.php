<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;

class RegisterController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'number' => 'required',
            'password' => 'required|confirmed',
            'block' => 'required',
            'flat_no' => 'required',
            'flat_type' => 'required',
            'flat_area' => 'required',
            'parking' => 'required'
        ]);
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'number' => $request->get('number'),
            'roll_id' => 1,
            'password' => \Hash::make($request->get('password')),
            'flat_no' => $request->get('flat_no'),
            'block' => $request->get('block'),
            'flat_type' => $request->get('flat_type'),
            'flat_area' => $request->get('flat_area'),
            'parking' => $request->get('parking')
        ]);

        return response()->json([
            'message' => 'Member added successfully',
            'data' => '',
            'success' => true
        ]);
        // return redirect()->back()->with('success','Member added successfully');
    }
    public function getdata(){
        $data = User::all();
        return $data;
    }
}
