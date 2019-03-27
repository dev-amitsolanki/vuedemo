<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use App\Model\Notice;

class NoticeController extends Controller
{
    public function create(Request $request){
        $this->validate($request,[
            'notice_type' => 'required',
            'notice_for' => 'required',
            'notice' => 'required'
        ]);

        $notice = Notice::create([
            'notice_type' => $request->get('notice_type'),
            'notice_for' => $request->get('notice_for'),
            'notice' => $request->get('notice'),
            'created_by' => Auth::user()->name,
            'status' => 'active'
        ]);
        return response()->json([
            'message' => 'notice created successfully',
            'success' => true
        ],200);
    }
    public function getnotice(){
        $notice = Notice::paginate(2);

        return response()->json([
            'data' => $notice,
            'success' => true
        ],200);
    }
    public function updateStatus(Request $request, $id){
        $notice = Notice::where('id',$id)->update([
            'status' => $request->get('status')
        ]);

        return response()->json([
            'message' => 'Notice status updated successfully',
            'success' => true
        ],200);
    }
    public function NoticeGet(){
        $notice = DB::table('notices')
                ->where('status','active')
                ->get();
        return $notice;
    }
}
