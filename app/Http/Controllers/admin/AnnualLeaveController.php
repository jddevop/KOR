<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Annual_leave;

class AnnualLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main_menu='settings';
        $sub_menu='settings';
        
        $annual_data = Annual_leave::where('status',0)->get();
        
        $annual_paid_data = Annual_leave::where('status',1)->get();
        
        $annual_rejected_data = Annual_leave::where('status',2)->get();
        
        return view('admin.annual_leave',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'annual_data'=>$annual_data,'annual_paid_data'=>$annual_paid_data,'annual_rejected_data'=>$annual_rejected_data]);
    }
    public function annual_leave_approve(Request $request)
    {
        if (!$request->id) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong.'
            ]);
        }
    
        $data = Annual_leave::find($request->id);
    
        if (!$data) {
            return response()->json([
                'status' => 0,
                'message' => 'Record not found.'
            ]);
        }
    
        $data->status = 1;
    
        if ($data->save()) {
            return response()->json([
                'status' => 1,
                'message' => 'Annual Leave Approved successfully!'
            ]);
        }
    
        return response()->json([
            'status' => 0,
            'message' => 'Annual Leave Approved failed.'
        ]);
    }
    public function annual_leave_reject(Request $request)
    {
        if (!$request->id) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong.'
            ]);
        }
    
        $data = Annual_leave::find($request->id);
    
        if (!$data) {
            return response()->json([
                'status' => 0,
                'message' => 'Record not found.'
            ]);
        }
    
        $data->status = 2;
    
        if ($data->save()) {
            return response()->json([
                'status' => 1,
                'message' => 'Annual Leave Rejected successfully!'
            ]);
        }
    
        return response()->json([
            'status' => 0,
            'message' => 'Annual Leave Rejected failed.'
        ]);
    }
}    