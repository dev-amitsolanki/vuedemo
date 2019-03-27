<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'number' => 'required',
            'password' => 'required|confirmed|min:6',
            'block' => 'required',
            'flat_no' => 'required',
            'flat_type' => 'required',
            'flat_area' => 'required',
            'parking' => 'required'
        ]);

        $roll = $request->get('user_roll') == null ? 2 : $request->get('user_roll');
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'number' => $request->get('number'),
            'roll_id' => $roll,
            'password' => \Hash::make($request->get('password')),
            'flat_no' => $request->get('flat_no'),
            'block' => $request->get('block'),
            'flat_type' => $request->get('flat_type'),
            'flat_area' => $request->get('flat_area'),
            'parking' => $request->get('parking'),
            'api_token' => str_random(60),
            'created_by' => Auth::user()->name,
        ]);

        return response()->json([
            'message' => 'Member added successfully',
            'data' => '',
            'success' => true
        ]);
        // return redirect()->back()->with('success','Member added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::where('id',$id)->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'number' => $request->get('number'),
            'block' => $request->get('block'),
            'flat_area' => $request->get('flat_area'),
            'flat_type' => $request->get('flat_type'),
            'parking' => $request->get('parking'),
        ]);
        if($request->get('pCheckbox') == true && $request->get('password') != null){
            $this->validate($request,[
                'password' => 'required|confirmed|min:6'
            ]);
            $user = User::where('id' , $id)->update([
                'password' => \Hash::make($request->get('password'))
            ]);
        }
        return response()->json([
            'message' => 'Member update successfully',
            'data' => '',
            'success' => true
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return response()->json([
            'message' => 'Member deleted successfully',
            'data' => '',
            'success' => true
        ],200);
    }
    public function getdata(){
        $data = User::select('*')->where('roll_id', 2)->paginate(5);
        // return $data;
        return response()->json([
            'message' => 'logout successfully',
            'data' => $data,
            'success' => true
        ],200);
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->flush();
        return response()->json([
            'message' => 'logout successfully',
            'data' => '',
            'success' => true
        ],200);
    }
    public function getuser(){
        $user = Auth::user()->roll_id;

         return $user;
    }
    public function userData(){
        $id = Auth::id();
        $user = User::select('*')->where('id',$id)->first();

        return $user;
    }
}
