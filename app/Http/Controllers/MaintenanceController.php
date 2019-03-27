<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use App\Model\MaintenanceCharges;
use App\Model\MaintenanceDate;


class MaintenanceController extends Controller
{
    public function addcharge(Request $request){
        $Mcount = MaintenanceCharges::where('member_type',$request->get('member_type'))
                                ->where('flat_type', $request->get('flat_type'))
                                ->count();
        if($Mcount > 0 ){
            if($request->get('m_date') != null){
                $mdate = MaintenanceDate::where('id',1)->update([
                    'm_date' => $request->get('m_date'),
                ]);
                }
            $maintenance = MaintenanceCharges::where('id', $request->get('id'))->update([
                'm_charge' => $request->get('m_charge'),
                'late_fee' => $request->get('late_fee')
                ]);
            $data = MaintenanceCharges::all();
        return response()->json([
            'message' => 'charge updated successfully',
            'data' => $data,
            'success' => true
        ],200);
        }else{
        $maintenance = MaintenanceCharges::create([
            'member_type' => $request->get('member_type'),
            'flat_type' => $request->get('flat_type'),
            'm_charge' => $request->get('m_charge'),
            'late_fee' => $request->get('late_fee')
        ]);
        }
        $data = MaintenanceCharges::all();
        return response()->json([
            'message' => 'charge created successfully',
            'data' => $data,
            'success' => true
        ],200);
    }
    public function Mntdata(Request $request){
        $maintenance = DB::table('maintenance_charges')
                        ->where('member_type', $request->get('member_type'))
                        ->where('flat_type', $request->get('flat_type'))
                        ->first();
        if($request->get('m_date') != null){
        $mdate = MaintenanceDate::where('id',1)->update([
            'm_date' => $request->get('m_date'),
        ]);
        }
        $mdate = DB::table('maintenance_dates')->where('id',1)->first();

        return response()->json([
            'data' => $maintenance,
            'mdate' => $mdate,
            'success' => true,
        ],200);
    }
    public function calcuMaint(Request $request){

        $userData = User::where('block', $request->get('block'))
                    ->where('flat_no', $request->get('flat_no'))
                    ->first();
        if($userData != null) {
        $mdate = MaintenanceDate::all();

        $maintenance = MaintenanceCharges::where('member_type', $request->get('flat_type'))
                      ->where('flat_type', $userData->flat_type)->first();
        $mdate = DB::table('maintenance_dates')->where('id',1)->first();
        if($mdate->m_date >= intval(date('d'))){
            $late = 0;
        }else{
            $late = $maintenance->late_fee;
        }
        $total = $maintenance->m_charge + $late;
        return response()->json([
            'data' => $maintenance,
            'late_fee' => $late,
            'total' => $total,
            'success' => true
        ],200);

        }else{
            return response()->json([
                'message' => 'data not found',
                'success' => false
            ],200);
        }
    }
}
