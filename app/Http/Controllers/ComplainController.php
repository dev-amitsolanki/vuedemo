<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use App\Model\Complains;

class ComplainController extends Controller
{
    public function addComplain(Request $request){
        $this->validate($request,[
            'message_type' => 'required',
            'complain_to' => 'required',
            'related_for' => 'required',
            'message' => 'required'
        ]);

        $complain = Complains::create([
            'message_type' => $request->get('message_type'),
            'complain_to' => $request->get('complain_to'),
            'related_for' => $request->get('related_for'),
            'message' => $request->get('message'),
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'status' => 'open',
            'is_deleted' => 0
        ]);
        return response()->json([
            'message' => 'complain created successfully',
            'data' => '',
            'success' => true
        ],200);
    }
    //admin side get complain
    public function getComplain(){
        $complain = Complains::select('*')->where('is_deleted', 0)->paginate(2);

        foreach($complain as $key=>$value){

            $value['date'] = $value->created_at->format('d/m/Y');
            $value['number'] = $value->users->number;

        }
        // dd($complain);
        return response()->json([
            'data' => $complain,
            'success' => true
        ],200);
    }
    public function resolution(Request $request, $id){
        $complain = Complains::where('id',$id)->update([
                'resolution' => $request->get('resolution'),
                'status' => $request->get('status'),
                'closed_by' => Auth::user()->name
        ]);

        return response()->json([
            'message' => 'complain resolution completed',
            'success' =>true
        ],200);
    }
    public function deleteComplain($id){
        $complain = Complains::where('id', $id)->update([
            'is_deleted' => '1',
            'deleted_by' => Auth::user()->name
        ]);

        return response()->json([
            'message' => 'Complain deleted',
            'success' => true
        ],200);
    }
    //member side get complain data
    public function complainData(Request $request){
        $id = Auth::user()->id;
        $complain = Complains::where('user_id',$id)->paginate(5);

        foreach($complain as $key=>$value){

            $value['date'] = $value->created_at->format('d/m/Y');
            $value['number'] = $value->users->number;

        }

        return response()->json([
            'data' => $complain,
            'success' => true
        ],200);

    }
}
