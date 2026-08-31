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

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main_menu='payroll';
        $sub_menu='payroll';
        
            $startDate = Carbon::createFromDate(date('Y'), 1, 1)->startOfWeek(Carbon::MONDAY);
            //$endDate = Carbon::now()->endOfWeek(Carbon::SUNDAY);
            $endDate = Carbon::now()->subWeek()->endOfWeek(Carbon::SUNDAY);
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
        return view('admin.payroll',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'arr_data'=>$arr_data]);
    }
    public function payroll_details(Request $request)
    {
        if ($request->start_date && $request->end_date) {

            $main_menu = 'payroll';
            $sub_menu = 'payroll';
    
            $week = $request->week;
    
            $start_date = $request->start_date;
            $end_date   = $request->end_date;
    
            $data = Users_shift::with('user')
                ->whereBetween('clock_in_date', [$start_date, $end_date])
                ->select('user_id')
                ->distinct()
                ->get();
    
            return view('admin.payroll_details', [
                'main_menu' => $main_menu,
                'sub_menu'  => $sub_menu,
                'data'      => $data,
                'start_date'=>$start_date,
                'week'=>$week,
                'end_date'=>$end_date
            ]);
    
        } else {
            return redirect('admin/payroll');
        }
    }
    public function export_payroll(Request $request)
    {
        $fileName = 'payroll.csv';
        $start_date=$request->from_date;
        $end_date=$request->to_date;
        $data_s = Users_shift::with('user')
                ->whereBetween('clock_in_date', [$start_date, $end_date])
                ->select('user_id')
                ->distinct()
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
            'Date of Birth',
            'PPS Number',
            'IBAN',
            'Sort Code',
            'Account Holder Name',
            'Bank Account Number',
            'Home Address',
            'Hours Worked',
            'Total Payment'
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
                $pps_number='';
                if($val->user){ 
                    $pps_number=$val->user->pps_number; 
                } 
                $birth_date='';
                if($val->user)
                {
                    $birth_date=$val->user->birth_date;
                }
                $bank_detail=get_users_bank_detail($val->user_id);
                $bank_detail=str_replace(' ', '',$bank_detail);
                $short_code=substr($bank_detail, 8,6);
                $bank_acc_num=substr($bank_detail, 14);
                
                $hour=get_shift_hours_payroll($val->user_id,$start_date,$end_date);
                
                $total = get_shift_hours_payroll_min($val->user_id,$start_date,$end_date);
                $tot=round($total,2);
                
                $home_add=get_users_bank_detail_home($val->user_id);
                $account_holder_name=get_users_bank_detail_account_holder_name($val->user_id);
                
                fputcsv($file, [
                    $staff_full_name,
                    $email,
                    $birth_date,
                    $pps_number,
                    $bank_detail,
                    $short_code,
                    $account_holder_name,
                    $bank_acc_num,
                    $home_add,
                    $hour,
                    $tot
                ]);
            }
    
            fclose($file);
        };
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=events.csv",
        ]);
    }
}    