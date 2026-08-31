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
use Carbon\Carbon;
use App\Models\Users_shift;

class ClockdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main_menu='clock_data';
        $sub_menu='clock_data';
        
            $startDate = Carbon::createFromDate(date('Y'), 1, 1)->startOfWeek(Carbon::MONDAY);
            $endDate = Carbon::now()->endOfWeek(Carbon::SUNDAY);
            
            $weekNumber = 1;
            $arr_data = [];
            $i = 0;
            
            while ($startDate <= $endDate) {
            
                $weekStart = $startDate->copy()->startOfWeek(Carbon::MONDAY);
                $weekEnd = $startDate->copy()->endOfWeek(Carbon::SUNDAY);
            
                
                if ($weekEnd > Carbon::now()) {
                    $weekEnd = Carbon::now()->copy();
                }
            
                $arr_data[$i]['week'] = "Week " . $weekStart->weekOfYear;
                $arr_data[$i]['start_date'] = $weekStart->format('Y-m-d');
                $arr_data[$i]['end_date'] = $weekEnd->format('Y-m-d');
            
                $i++;
            
                $startDate->addWeek(); // +7 days
                $weekNumber++;
            }
             $arr_data = array_reverse($arr_data);
        return view('admin.clock_data',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'arr_data'=>$arr_data]);
    }
    public function clock_data_details(Request $request)
    {
        if ($request->start_date && $request->end_date) {

            $main_menu = 'clock_data';
            $sub_menu = 'clock_data';
    
            $week = $request->week;
    
            $start_date = $request->start_date;
            $end_date   = $request->end_date;
    
            $data = Users_shift::with('user')
                ->whereBetween('clock_in_date', [$start_date, $end_date])
                ->select('*')
                ->get();
    
            return view('admin.clock_data_details', [
                'main_menu' => $main_menu,
                'sub_menu'  => $sub_menu,
                'data'      => $data,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
                'week'=>$week
            ]);
    
        } else {
            return redirect('admin/clock_data');
        }
    }
    public function export_clockin(Request $request)
    {
        $fileName = 'clockin.csv';
        $start_date=$request->from_date;
        $end_date=$request->to_date;
       
                
        $data_s = Users_shift::with('user')
                ->whereBetween('clock_in_date', [$start_date, $end_date])
                ->select('*')
                ->get();
    
        $headers = [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate",
            "Expires"             => "0"
        ];
  
        $columns = [
            'Staff Full Name',
            'Email Address',
            'Event',
            'Clock In',
            'Clock Out',
            'Clock In Note',
            'Clock Out Note',
            'Total Hours',
            'Shift Time'
        ];
        $callback = function () use ($data_s, $columns, $start_date, $end_date) {
    
            $file = fopen('php://output', 'w');
    
            // UTF-8 BOM (fix Excel issue)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
    
            fputcsv($file, $columns);
    
            foreach ($data_s as $key=>$val) {
                $staff_full_name='';
                if($val->user){ 
                    $staff_full_name=$val->user->first_name.' '.$val->user->last_name; 
                } 
                $email='';
                if($val->user){ 
                    $email=$val->user->email; 
                } 
                $event_name='';
                if($val->event){ 
                    $event_name=$val->event->name; 
                }
                $clock_in_date_time='';
                if($val->clock_in_date_time!=''){
                    $clock_in_date_time=date("Y-m-d H:i",strtotime($val->clock_in_date_time));
                }
                $clock_out_date_time='';
                if($val->clock_out_date_time!=''){
                    $clock_out_date_time=date("Y-m-d H:i",strtotime($val->clock_out_date_time));
                }
                $clock_in_explanatory_note=$val->clock_in_explanatory_note;
                $clock_out_explanatory_note=$val->clock_out_explanatory_note;
                
                $total_hours='';
                if($val->clock_in_date_time!='' && $val->clock_out_date_time!=''){ 
                    $total_hours=getTimeDifference($val->clock_in_date_time,$val->clock_out_date_time); 
                }
                $shift_text='';
                $shift_data=get_clockdata_shift($val->user_id,$val->event_id); 
                foreach ($shift_data as $shift) {
                $shift_text .= date('h:i A', strtotime($shift['start_time'])) .
                    ' to ' .
                    date('h:i A', strtotime($shift['end_time'])) . " | ";
            }

            // Remove last separator
            $shift_text = rtrim($shift_text, ' | ');
                
                fputcsv($file, [
                    $staff_full_name,
                    $email,
                    $event_name,
                    $clock_in_date_time,
                    $clock_out_date_time,
                    $clock_in_explanatory_note,
                    $clock_out_explanatory_note,
                    $total_hours,
                    $shift_text
                ]);
            }
    
            fclose($file);
        };
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=events.csv",
        ]);
    }
   public function edit_clockin_clockout(Request $request)
    {
        $input = $request->all();
    
        $rules['id'] = 'required';
		$messages['id.required']='Id is required';
    
		$rules['clock_in'] = 'required';
		$messages['clock_in.required']='clock in is required';

		$rules['clock_out'] = 'required';
		$messages['clock_out.required']='clock out is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $id=$request->id;
		    $clock_in=$request->clock_in;
		    $clock_out=$request->clock_out;
		   
		    $data = Users_shift::find($id);
		    $data->clock_in_date=date("Y-m-d",strtotime($clock_in));
		    $data->clock_in_time=date("H:i:s",strtotime($clock_in));
			$data->clock_in_date_time=date("Y-m-d H:i:s",strtotime($clock_in));
			$data->clock_out_date=date("Y-m-d",strtotime($clock_out));
		    $data->clock_out_time=date("H:i:s",strtotime($clock_out));
			$data->clock_out_date_time=date("Y-m-d H:i:s",strtotime($clock_out));
			if($data->save())
			{
                $json_data['status'] = 1;
                $json_data['message']    = 'Clock updated successfully.';
                echo json_encode($json_data);
                exit;
			}else{
			    $json_data['status'] = 0;
				$json_data['message']    = 'Clock updated fail.';
				echo json_encode($json_data);
				exit;
			}
    	}else{
			$json_data['status']=0;
    		$json_data['message']	= 'Something went wrong.';
    		echo json_encode($json_data);
    		exit;
		}
    }
}    