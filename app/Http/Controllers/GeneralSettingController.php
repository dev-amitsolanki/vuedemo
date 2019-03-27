<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use App\Model\Block;
use App\Model\FlatType;

class GeneralSettingController extends Controller
{
    public function addblock(Request $request){

        $this->validate($request,[
            'block' => 'required'
        ]);

        $block = Block::create([
            'block' => $request->get('block'),
            'created_by' => Auth::user()->name
        ]);
        $data = DB::table('blocks')->select('*')->get();
        return response()->json([
            'message' => 'Block added successfully',
            'data' => $data,
            'success' => true
        ],200);
    }
    public function getBlock(){
        $data = DB::table('blocks')->select('*')->get();

        return $data;
    }
    public function deleteBlock($id){

        $block = Block::find($id)->delete();

        return response()->json([
            'message' => 'block deleted successfully',
            'success' => true
        ],200);
    }
    public function addFlatType(Request $request){
        $this->validate($request,[
            'flat_type' => 'required'
        ]);

        $flatType = FlatType::create([
            'flat_type' => $request->get('flat_type'),
            'created_by' => Auth::user()->name
        ]);

        return response()->json([
            'message' => 'flat type added successfully',
            'success' => true
        ],200);
    }
    public function getFlatType(){

        $flatType = DB::table('flat_types')->select('*')->get();

        return $flatType;
    }
    public function deleteFlatType($id){
       $flatType = FlatType::find($id)->delete();

       return response()->json([
           'message' => 'flat type remove successfully',
           'success' => true
       ],200);
    }
}
