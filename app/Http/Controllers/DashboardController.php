<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Session;
use Validator;
use Hash;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bank_account_details;
use App\Models\City;
use App\Models\Event;
use App\Models\Save_event;
use App\Models\Help_support;
use App\Models\Users_event_status;
use App\Models\Users_shift;
use App\Models\Event_shift;
use App\Models\Occupations;
use App\Models\English_level;
use App\Models\Employer;
use App\Models\Annual_leave;
use App\Models\Notification;
use App\Models\Terms_of_employment;
use Carbon\Carbon;
use App\Models\Support_number;


class DashboardController extends Controller
{
    public function dashboard(Request $request)
    { 
        $menu = 'dashboard';
        $userId = Session::get('user_data')->id;
        
        
        $bank_address='';
        $datab = Bank_account_details::where('user_id',$userId)->get()->first();
        if(!empty($datab))
        {
            $bank_address=1;
        }
        
        
        $data_user = User::find($userId);
        
        $today=date('Y-m-d');
        $total_upcoming = 0;

        $user_event_data = Users_event_status::with('event')
            ->where('user_id', $userId)
            ->whereHas('event', function ($q) {
                $q->where('start_date', '>', date("Y-m-d"));
            })
            ->get();
        
        foreach ($user_event_data as $val) {
            $upcomingshiftCount = Event_shift::whereRaw(
                "FIND_IN_SET(?, users_event_status_id)",
                [$val->id]
            )->count();
            $total_upcoming += $upcomingshiftCount;
        }
        
        $events_ongoing = DB::table('event')
            ->leftJoin('users_event_status', function($join) use ($userId) {
                $join->on('event.id', '=', 'users_event_status.event_id')
                     ->where('users_event_status.user_id', $userId);
        })
        
            // Only records where entry exists
            ->whereNotNull('users_event_status.event_id')
            ->whereDate('event.end_date', '>=', $today)
            ->Where('users_event_status.event_status', 6)
            ->select(
                'event.*',
                'users_event_status.event_status as current_invitation_status',
                'users_event_status.role as role_new'
            )
            ->get();
            
            
            $events_accept = DB::table('event')
            ->leftJoin('users_event_status', function($join) use ($userId) {
                $join->on('event.id', '=', 'users_event_status.event_id')
                     ->where('users_event_status.user_id', $userId);
            })
        
            // Only records where entry exists
            ->whereNotNull('users_event_status.event_id')
            ->where('users_event_status.event_status', 5)
            ->whereDate('event.end_date', '>=', $today)
            ->select(
                'event.*',
                'users_event_status.event_status as current_invitation_status',
                'users_event_status.role as role_new'
            )
            ->get();
            
        $events_applied = DB::table('event')
            ->leftJoin('users_event_status', function($join) use ($userId) {
                $join->on('event.id', '=', 'users_event_status.event_id')
                     ->where('users_event_status.user_id', $userId);
            })
            // Only records where entry exists
            ->whereNotNull('users_event_status.event_id')
            ->whereDate('event.end_date', '>=', $today)
            ->where('users_event_status.event_status', 3)
            ->select(
                'event.*',
                'users_event_status.event_status as current_invitation_status'
            )
            ->get();
        
        /*$events = DB::table('event')
        ->leftJoin('users_event_status', function($join) use ($userId) {
            $join->on('event.id', '=', 'users_event_status.event_id')
                 ->where('users_event_status.user_id', '=', $userId);
        })
        ->where(function($query) use ($today) {
            // Case 1: event_status = 1 → show till end_date
            $query->where(function($q) use ($today) {
                $q->where('event.event_status', 1)
                  ->whereDate('event.end_date', '>=', $today);
            });
    
            // Case 2: event_status = 0 → show till start_date
            $query->orWhere(function($q) use ($today) {
                $q->where('event.event_status', 0)
                  ->whereDate('event.start_date', '>=', $today);
            });
        })
        ->where(function($query) {
                $query->whereNull('users_event_status.event_id')
                      ->orWhere('users_event_status.event_status', 1);
            })
        ->select(
        'event.*',
           DB::raw('IF(users_event_status.event_id IS NULL, 0, users_event_status.event_status) as current_invitation_status')
            )
        ->get();*/
        
        /*$events = DB::table('event')
        ->leftJoin('users_event_status', function ($join) use ($userId) {
            $join->on('event.id', '=', 'users_event_status.event_id')
                 ->where('users_event_status.user_id', '=', $userId);
        })
        ->whereDate('event.start_date', '>=', $today)
                ->where(function ($query) {
                $query->where('event.event_status', 1)
                      ->orWhere(function ($q) {
                          $q->where('event.event_status', 0)
                            ->where('users_event_status.event_status', 1);
                      });
            })
        ->select(
            'event.*',
            DB::raw('COALESCE(users_event_status.event_status, 0) as current_invitation_status')
        )
        ->orderBy('event.start_date', 'asc')
        ->get();*/
        
        $events = DB::table('event')
    ->leftJoin('users_event_status', function ($join) use ($userId) {
        $join->on('event.id', '=', 'users_event_status.event_id')
             ->where('users_event_status.user_id', '=', $userId);
    })
    ->whereDate('event.start_date', '>=', $today)
    ->where(function ($query) {
        $query->where(function ($q) {
            $q->where('event.event_status', 1)
              ->where(function ($sub) {
                  $sub->whereNull('users_event_status.event_status')
                      ->orWhere('users_event_status.event_status', 1);
              });
        })
        ->orWhere(function ($q) {
            $q->where('event.event_status', 0)
              ->where('users_event_status.event_status', 1);
        });
    })
    ->select(
        'event.*',
        DB::raw('COALESCE(users_event_status.event_status, 0) as current_invitation_status')
    )
    ->orderBy('event.start_date', 'asc')
    ->get();
        
        return view('dashboard', ['page' => $menu,'view_event'=>$events,'data_user'=>$data_user,'events_ongoing'=>$events_ongoing,'events_accept'=>$events_accept,'events_applied'=>$events_applied,'upcomingshiftCount'=>$total_upcoming,'bank_address'=>$bank_address]);
    }
    public function my_events(Request $request)
    { 
        $menu = 'myevent';

        return view('my_events', ['page' => $menu]);
    }
    public function profile(Request $request)
    { 
        $menu = 'profile';
        $id = Session::get('user_data')->id;
        $data = User::find($id);
        
        $account_holder_name='';
        $home_address='';
        $iban='';
        $bank_address='';
        $datab = Bank_account_details::where('user_id',$id)->get()->first();
        if(!empty($datab))
        {
            $account_holder_name=$datab['account_holder_name'];
            $home_address=$datab['home_address'];
            $iban=$datab['iban'];
            $bank_address=$datab['bank_address'];
        }
        $databank=array();
        $databank['account_holder_name']=$account_holder_name;
        $databank['home_address']=$home_address;
        $databank['iban']=$iban;
        $databank['bank_address']=$bank_address;
        
        $employer_name='';
        $employer_number='';
        $email='';
        $contact_number='';
        $image='';
        $dataemp = Employer::where('id',1)->get()->first();
        if(!empty($dataemp))
        {
            $employer_name=$dataemp['employer_name'];
            $employer_number=$dataemp['employer_number'];
            $email=$dataemp['email'];
            $contact_number=$dataemp['contact_number'];
            $image=asset('upload/employer/' . $dataemp->image);
        }
        $dataemp=array();
        $dataemp['employer_name']=$employer_name;
        $dataemp['employer_number']=$employer_number;
        $dataemp['email']=$email;
        $dataemp['contact_number']=$contact_number;
        $dataemp['image']=$image;
        
		$total_upcoming = 0;

        $user_event_data = Users_event_status::with('event')
            ->where('user_id', $id)
            ->whereHas('event', function ($q) {
                $q->where('start_date', '>', date("Y-m-d"));
            })
            ->get();
        
        foreach ($user_event_data as $val) {
        
            $upcomingshiftCount = Event_shift::whereRaw(
                "FIND_IN_SET(?, users_event_status_id)",
                [$val->id]
            )->count();
        
            $total_upcoming += $upcomingshiftCount;
        }
		
        return view('profile', ['page' => $menu,'data'=>$data,'databank'=>$databank,'upcomingshiftCount'=>$total_upcoming,'dataemp'=>$dataemp]);
    }
    public function shifts(Request $request)
    { 
        $menu = 'shifts';

        return view('shifts', ['page' => $menu]);
    }
    public function shift_detail(Request $request)
    { 
        if(!empty($request->id))
        {
            $event_id=$request->id;
            $data_event = Event::where('id',$event_id)->get()->first();
            if(!empty($data_event))
            {
                $menu = 'shift-detail';
                $user_id = Session::get('user_data')->id;
                $shift_start_time='';
                $shift_end_time='';
                $role=$data_event->role;
                $data_event_u = Users_event_status::where('event_id',$event_id)->where('user_id',$user_id)->get()->first();
                $aa=0;
                if(!empty($data_event_u))
                {
                    if($data_event_u->role!='')
                    {
                    $role=$data_event_u->role;
                    }
                    $activeShift = Event_shift::whereRaw("FIND_IN_SET(?, users_event_status_id)", [$data_event_u->id])
                            ->where('event_id', $event_id)
                            ->orderBy('id', 'DESC') // last record mate
                            ->first();
                    if(!empty($activeShift))
                    { 
                        $aa=1;
                        if($data_event['start_date'] <= date('Y-m-d') && $data_event['end_date'] >= date('Y-m-d'))
                        {
                            $shift_start_time=date('Y-m-d').' '.$activeShift['start_time'];
                            $shift_start_time=date("Y-m-d H:i:s",strtotime($shift_start_time));
                        
                            $shift_end_time=date('Y-m-d').' '.$activeShift['end_time'];
                            $shift_end_time=date("Y-m-d H:i:s",strtotime($shift_end_time));
                            
                            if ($activeShift['end_time'] < $activeShift['start_time']) {
                                // end time next day ma move karvu
                                $shift_end_time = date("Y-m-d H:i:s", strtotime($shift_end_time . ' +1 day'));
                            }
                            
                        }
                    }
                }
                
                $arr_time = [];

                $user_event_data = Users_event_status::where('user_id', $user_id)
                    ->where('event_id', $event_id)
                    ->first(); 
                
                if ($user_event_data) {
                
                    $upcomingShift = Event_shift::whereRaw(
                        "FIND_IN_SET(?, users_event_status_id)",
                        [$user_event_data->id]
                    )->get();
                
                    foreach ($upcomingShift as $val) {
                        $arr_time[] = [
                            'name'=>$val->name,
                            'start_time' => date('h:i A', strtotime($val->start_time)),
                            'end_time'   => date('h:i A', strtotime($val->end_time)),
                        ];
                    }
                }
                
                
               /*if($aa==0){
                   return redirect('dashboard');
               }*/
                return view('shift_detail', ['page' => $menu,'data_event'=>$data_event,'shift_start_time'=>$shift_start_time,'shift_end_time'=>$shift_end_time,'role'=>$role,'arr_time'=>$arr_time]);
            }else{
                return redirect('dashboard');
            }
        }else{
            return redirect('dashboard');
        }
    }
    public function sync_status(Request $request)
    { 
        $menu = 'sync-status';
        return view('sync_status', ['page' => $menu]);
    }
    public function save_events(Request $request)
    { 
        $menu = 'save-event';
        
        $user_id = Session::get('user_data')->id;
        
        $today=date('Y-m-d');
        
        $save_data = Save_event::with('event')
        ->where('user_id', $user_id)
        ->whereHas('event', function($query) use ($today) {
    
            $query->where(function($main) use ($today) {
                // Case 1: event_status = 1 → till end_date
                $main->where(function($q) use ($today) {
                    $q->where('event_status', 1)
                      ->whereDate('end_date', '>=', $today);
                })
    
                // Case 2: event_status = 0 → till start_date
                ->orWhere(function($q) use ($today) {
                    $q->where('event_status', 0)
                      ->whereDate('start_date', '>=', $today);
                });
            });
        })
        ->get();
        
        return view('save_events', ['page' => $menu,'save_data'=>$save_data]);
    }
    public function annual_leave(Request $request)
    { 
        $menu = 'annual-leave';

        $start_date=date("Y-01-01");
        $start_date=date("jS F Y",strtotime($start_date));
        $end_date=date("Y-12-31");
        $end_date=date("jS F Y",strtotime($end_date));

        $user_id = Session::get('user_data')->id;
        $date=date("Y-01-01");
        $date=date("Y-m-d",strtotime($date));
        $data_ann = Annual_leave::where('user_id', $user_id)
        ->orderBy('date', 'DESC')
        ->first();
        
        $cur_date=$date;
        if(!empty($data_ann))
        {
            if($data_ann->date < $date)
            {
                $mdate=date("Y-03-31");
                $mdate=date("Y-m-d",strtotime($mdate));
                if(date('Y-m-d') <= $mdate)
                {
                    $newDate = date("Y-m-d", strtotime($data_ann->date . " +1 day"));
                    $cur_date=$newDate;
                }
            }else{
                 $newDate = date("Y-m-d", strtotime($data_ann->date . " +1 day"));
                $cur_date=$newDate;
            }
        }
        $eligible_leave_hours=get_shift_hours_payroll($user_id,$cur_date,date('Y-m-d'));
        
        $annual_data = Annual_leave::where('user_id',$user_id)->get();
        
        
        return view('annual_leave', ['page' => $menu,'eligible_leave_hours'=>$eligible_leave_hours,'start_date'=>$start_date,'end_date'=>$end_date,'annual_data'=>$annual_data]);
    }
    public function change_password(Request $request)
    { 
        $menu = 'change-password';
                                
        return view('change_password', ['page' => $menu]);
    }
    public function event_details(Request $request)
    { 
        $user_id = Session::get('user_data')->id;
        
        $id=$request->id;
        
        $menu = 'event-detail';
        $data = Event::where('id',$id)->get()->first();
        
        $save_status=0;
        $data_save = Save_event::where('user_id',$user_id)->where('event_id',$id)->get()->first();
        if(!empty($data_save))
        {
            $save_status=1;
        }
        $whatsaa_status=0;
        $confirm_status=1;
        $data_user_event = Users_event_status::where('user_id',$user_id)->where('event_id',$id)->get()->first();
        if(!empty($data_user_event))
        {
            $whatsaa_status=$data_user_event['event_status'];
            if($data_user_event['event_status']!=1)
            {
                $confirm_status=0;
            }
        }else{
            if($data['event_status']==0){
                $confirm_status=0;
            }
        }
        if($data['end_date'] < date('Y-m-d'))
        {
            $confirm_status=0;
        }
        $support_number='';
        $data_supp = Support_number::where('id',1)->get()->first();
        if(!empty($data_supp))
        {
            $support_number=$data_supp['support_number'];
           
        }
        
        $arr_time = [];

        $user_event_data = Users_event_status::where('user_id', $user_id)
            ->where('event_id', $id)
            ->first(); 
        
        if ($user_event_data) {
        
            $upcomingShift = Event_shift::whereRaw(
                "FIND_IN_SET(?, users_event_status_id)",
                [$user_event_data->id]
            )->get();
        
            foreach ($upcomingShift as $val) {
                $arr_time[] = [
                    'name'=>$val->name,
                    'start_time' => date('h:i A', strtotime($val->start_time)),
                    'end_time'   => date('h:i A', strtotime($val->end_time)),
                ];
            }
        }
        
        return view('event_details', ['page' => $menu,'data'=>$data,'save_status'=>$save_status,'confirm_status'=>$confirm_status,'support_number'=>$support_number,'whatsaa_status'=>$whatsaa_status,'arr_time'=>$arr_time]);
    }
    public function faq(Request $request)
    { 
        $menu = 'faq';
        $data_faq = Help_support::where('status',1)->get();
        return view('faq', ['page' => $menu,'data_faq'=>$data_faq]);
    }
    public function notifications(Request $request)
    { 
        $menu = 'notification';

        $user_id = Session::get('user_data')->id;

        Notification::where('notification_type', 0)
                ->where('to_id', $user_id)
                ->where('status', 0)
                ->update(['status' => 1]);
		
        $view_data=Notification::where('notification_type',0)->where('to_id', $user_id)->orderBy('id', 'desc')->get();

        return view('notifications', ['page' => $menu,'view_data'=>$view_data]);
    }
    public function request_in_review(Request $request)
    { 
        $menu = 'request-in-review';

        return view('request_in_review', ['page' => $menu]);
    }
    public function share_app(Request $request)
    { 
        $menu = 'share-app';

        return view('share_app', ['page' => $menu]);
    }
    public function update_bank_detail(Request $request)
    { 
        $menu = 'update-bank-detail';

        $id = Session::get('user_data')->id;
        $account_holder_name='';
        $home_address='';
        $iban='';
        $bank_address='';
        $datab = Bank_account_details::where('user_id',$id)->get()->first();
        if(!empty($datab))
        {
            $account_holder_name=$datab['account_holder_name'];
            $home_address=$datab['home_address'];
            $iban=$datab['iban'];
            $bank_address=$datab['bank_address'];
        }
        $data=array();
        $data['account_holder_name']=$account_holder_name;
        $data['home_address']=$home_address;
        $data['iban']=$iban;
        $data['bank_address']=$bank_address;
        return view('update_bank_detail', ['page' => $menu,'data'=>$data]);
    }
    public function do_update_bank_detail(Request $request)
    {
		$input = $request->all();

		$rules['account_holder_name'] = 'required';
		$messages['account_holder_name.required']='Account Holder Name is required';

		$rules['home_address'] = 'required';
		$messages['home_address.required']='Home Address is required';
		
		$rules['iban'] = 'required';
		$messages['iban.required']='IBAN is required';
		
		$rules['bank_address'] = 'required';
		$messages['bank_address.required']='Bank Address is required';

		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
		        $id = Session::get('user_data')->id;
    		    $account_holder_name=$request->account_holder_name;
    		    $home_address=$request->home_address;
    		    $iban=$request->iban;
    		    $bank_address=$request->bank_address;
    		    $data = Bank_account_details::where('user_id',$id)->get()->first();
                if(!empty($data))
                {
                    $data = Bank_account_details::find($data['id']);
                    $data->account_holder_name=$account_holder_name;
    				$data->home_address=$home_address;
    				$data->iban=$iban;
    				$data->bank_address=$bank_address;
    				$data->save();
                }else{
    			    $ins=new Bank_account_details;
    			    $ins->user_id=$id;
    				$ins->account_holder_name=$account_holder_name;
    				$ins->home_address=$home_address;
    				$ins->iban=$iban;
    				$ins->bank_address=$bank_address;
    				$ins->save();
                }
                return redirect('profile')->with('success', 'Your bank has been updated.');
		}else{
				return redirect()->back()->withErrors($validator)
                        ->withInput();
		}
	}
    public function upload_document(Request $request)
    { 
        $menu = 'upload-document';
        $id = Session::get('user_data')->id;
        $data = User::find($id);
        
        $doc='';
        $dataemp = Terms_of_employment::where('id',1)->get()->first();
        if(!empty($dataemp))
        {
            if($dataemp->doc!=''){
                $doc=asset('upload/terms_of_employment/' . $dataemp->doc);
            }
        }
        $dataemp=array();
        $dataemp['doc']=$doc;
        
        
        return view('upload_document', ['page' => $menu,'data'=>$data,'dataemp'=>$dataemp]);
    }
    public function edit_profile(Request $request)
    { 
        $menu = 'edit-profile';
        $id = Session::get('user_data')->id;
        $data = User::find($id);
        
        $nationality=$data['nationality'];
        $city_data = City::where('status', 1)
        ->where(function($q) use ($nationality) {
            $q->where('nationality', $nationality)
              ->orWhere('sort', 1);
        })
        ->orderByRaw("
            CASE 
                WHEN nationality = ? THEN 0
                WHEN sort = 1 THEN 1
            END
        ", [$nationality])
        ->orderBy('name', 'ASC')
        ->get();
        
        $area_experience_arr = explode(',', $data['area_experience_occupations_id']);
        
        $english_level_data = English_level::where('status', 1)->orderBy('name', 'ASC') ->get();
        
        $occupations_data = Occupations::where('status', 1)->orderBy('name', 'ASC') ->get();
        
        return view('edit_profile', ['page' => $menu,'data'=>$data,'city_data'=>$city_data,'area_experience_arr'=>$area_experience_arr,'english_level_data'=>$english_level_data,'occupations_data'=>$occupations_data]);
    }
    public function settings(Request $request)
    { 
        $menu = 'settings';
        $doc='';
        $dataemp = Terms_of_employment::where('id',1)->get()->first();
        if(!empty($dataemp))
        {
            if($dataemp->doc!=''){
                $doc=asset('upload/terms_of_employment/' . $dataemp->doc);
            }
        }
        $dataemp=array();
        $dataemp['doc']=$doc;
        return view('settings', ['page' => $menu,'dataemp'=>$dataemp]);
    }
    public function change_password_update(Request $request)
    {
        $input = $request->all();
        $id=Session::get('user_data')->id;
		$data_user=User::find($id);
         $validator = Validator::make($request->all(), [
                'opassword' => 'required',
                'npassword' => 'required',
                'cpassword' => 'required|same:npassword',
            ], [
                'opassword.required' => 'Current Password is required',
                'npassword.required' => 'Password is required',
                'cpassword.required' => 'Confirm Password is required',
                'cpassword.same' => 'Password and Confirm Password do not match',
            ]);
            
		if ($validator->fails()) {
            $json_data['status']=0;
				$json_data['message']	= 'Something is wrong';
				echo json_encode($json_data);
				exit;
        }
        
        $db_password=$data_user->password;
		$opassword = $request->opassword;
		$npassword = $request->npassword;
        
        if(Hash::check($opassword, $db_password))
		{
			$npassword = Hash::make($npassword);				
			$admin = User::find($id);
			$admin->password = $npassword;
			$admin->save();
			
			$json_data['status']=1;
			$json_data['message']	= 'Password change successfully !';
			echo json_encode($json_data);
			exit;
		}else{
		     $json_data['status']=0;
			$json_data['message']	= 'Wrong Current Password!';
			echo json_encode($json_data);
			exit;
		}	
	}
	public function do_edit_profile(Request $request)
    {
        $id = Session::get('user_data')->id;
        $data = User::find($id);
        if(!empty($data))
        {
    		$input = $request->all();
    		$rules['first_name'] = 'required';
    		$messages['first_name.required']='First Name is required';
    
    		$rules['last_name'] = 'required';
    		$messages['last_name.required']='Last Name is required';
    
    		$rules['phone'] = 'required';
    		$messages['phone.required']='Phone is required';
    		
    		$rules['gender'] = 'required';
    		$messages['gender.required']='Gender is required';
    		
    		$rules['birth_date'] = 'required';
    		$messages['birth_date.required']='Birth Date is required';
    		
    		$rules['city_id'] = 'required';
    		$messages['city_id.required']='City Id is required';
    		
    		if(empty($request->area_experience))
    		{
    		    $rules['area_experience'] = 'required';
    		    $messages['area_experience.required']='Area Experience is required';
    		}
    
            /*$rules['additional_experience'] = 'required';
    		$messages['additional_experience.required']='Additional Experience is required';*/
    		
            if($data['nationality']=='EU' || $data['nationality']=='Non-EU')
    		{
    		    $rules['english_level'] = 'required';
    		    $messages['english_level.required']='English Level is required';
    		}
    
    		$validator = Validator::make($input, $rules,$messages);
    		if ($validator->passes()) {
    		     try {
        		    $first_name=$request->first_name;
        		    $last_name=$request->last_name;
        		    $phone=$request->phone;
        		    $country_code=$request->country_code;
        		    $country_short_code=$request->country_short_code;
        		    
        		    $phone_text=$country_code.$phone;
        		    $gender=$request->gender;
        		    $birth_date=$request->birth_date;
        		    
        		    $city_id=$request->city_id;
        		    $area_experience = '';
                    if (!empty($request->area_experience)) {
                        $area_experience = implode(',', $request->area_experience);
                    }
        		    $additional_experience=$request->additional_experience;
        		    $english_level=$request->english_level;
        		    
        			    $data = User::find($id);
        				$data->first_name=$first_name;
        				$data->last_name=$last_name;
        		
        				$data->phone=$phone;
        				$data->phone_text=$phone_text;
        				$data->country_code=$country_code;
        				$data->country_short_code=$country_short_code;
        				$data->gender=$gender;
        				$data->birth_date=date("Y-m-d",strtotime($birth_date));
        			
        				$data->city_id=$city_id;
        				
        				$data->area_experience_occupations_id=$area_experience;
        				$data->additional_experience=$additional_experience;
        				
        				if($data['nationality']=='EU' || $data['nationality']=='Non-EU')
            			{
        				    $data->english_level_id=$english_level;
            			}
            			if ($request->hasFile('profile_picture')) {
            				$row_img=User::find($id);
            				$image_path = base_path("public/upload/users/".$row_img->image); 
            				if(File::exists($image_path)) {
            					File::delete($image_path);
            				}
            				$image = $request->file('profile_picture');
            				$file_name =str_replace(" ","-",$image->getClientOriginalName());
            				$file_name=$id.$file_name;
            				$destinationPath = base_path('public/upload/users');
            				$image->move($destinationPath, $file_name);
            				$data->profile_picture=$file_name;
            			}
        				if($data->save())
        				{
        				    $data_admin=User::find($id);
			                Session::put('user_data', $data_admin);
			                session()->save();
        				    
                            $json_data['status'] = 1;
                            $json_data['message']    = 'Your profile has been updated.';
                            echo json_encode($json_data);
                            exit;
        				}else{
        				    $json_data['status'] = 0;
        					$json_data['message']    = 'Profile updated fail.';
        					echo json_encode($json_data);
        					exit;
        				}
    		     } catch (\Exception $e) {
                    $json_data['status'] = 0;
    				$json_data['message']    = $e->getMessage();
    				echo json_encode($json_data);
    				exit;
                }
    		}else{
    				$json_data['status']=0;
            		$json_data['message']	= 'Something went wrong.';
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
	public function do_document(Request $request)
    {
        $id = Session::get('user_data')->id;
        $document_name=$request->document_name;
        if ($request->hasFile('document')) {
          if($document_name=='Work permit'){  
                $row_img=User::find($id);
                if($row_img->permission_to_work1!=''){
        			$image_path = base_path("public/upload/users/".$row_img->permission_to_work1); 
        			if(File::exists($image_path)) {
        				File::delete($image_path);
        			}
                }
                $data = User::find($id);
    			$image = $request->file('document');
    			$file_name =str_replace(" ","-",$image->getClientOriginalName());
    			$file_name=$id.'_permit_'.$file_name;
    			$destinationPath = base_path('public/upload/users');
    			$image->move($destinationPath, $file_name);
    			$data->permission_to_work1=$file_name;
    			$data->save();
          }else if($document_name=='Passport')
          {
                $row_img=User::find($id);
                if($row_img->passport!=''){
        			$image_path = base_path("public/upload/users/".$row_img->passport); 
        			if(File::exists($image_path)) {
        				File::delete($image_path);
        			}
                }
                $data = User::find($id);
    			$image = $request->file('document');
    			$file_name =str_replace(" ","-",$image->getClientOriginalName());
    			$file_name=$id.'_passport_'.$file_name;
    			$destinationPath = base_path('public/upload/users');
    			$image->move($destinationPath, $file_name);
    			$data->passport=$file_name;  
    			$data->save();
          }else if($document_name=='National ID')
          {
                $row_img=User::find($id);
                if($row_img->national_id!=''){
        			$image_path = base_path("public/upload/users/".$row_img->national_id); 
        			if(File::exists($image_path)) {
        				File::delete($image_path);
        			}
                }
                $data=User::find($id);
    			$image = $request->file('document');
    			$file_name =str_replace(" ","-",$image->getClientOriginalName());
    			$file_name=$id.'_national_'.$file_name;
    			$destinationPath = base_path('public/upload/users');
    			$image->move($destinationPath, $file_name);
    			$data->national_id=$file_name;
    			$data->save();
          }else if($document_name=='CV')
          {
              $row_img=User::find($id);
                if($row_img->cv!=''){
        			$image_path = base_path("public/upload/users/".$row_img->cv); 
        			if(File::exists($image_path)) {
        				File::delete($image_path);
        			}
                }
                $data=User::find($id);
    			$image = $request->file('document');
    			$file_name =str_replace(" ","-",$image->getClientOriginalName());
    			$file_name=$id.'cv'.$file_name;
    			$destinationPath = base_path('public/upload/users');
    			$image->move($destinationPath, $file_name);
    			$data->cv=$file_name;
    			$data->save();
          }else if($document_name=='Other relevant document')
          {
              $row_img=User::find($id);
                if($row_img->other_relevant_document!=''){
        			$image_path = base_path("public/upload/users/".$row_img->other_relevant_document); 
        			if(File::exists($image_path)) {
        				File::delete($image_path);
        			}
                }
                $data=User::find($id);
    			$image = $request->file('document');
    			$file_name =str_replace(" ","-",$image->getClientOriginalName());
    			$file_name=$id.'_other_'.$file_name;
    			$destinationPath = base_path('public/upload/users');
    			$image->move($destinationPath, $file_name);
    			$data->other_relevant_document=$file_name;
    			$data->save();
          }
          $first_name=Session::get('user_data')->first_name;
          $last_name=Session::get('user_data')->last_name;
          $name=$first_name.' '.$last_name;
          $message=$name.' staff member has uploaded or updated a document for review.';
          send_notification($id,0,0,1,$message,1,0);
          
        }
        $json_data['status'] = 1;
        $json_data['message']    = 'Document has been updated.';
        echo json_encode($json_data);
        exit;
    }
    public function event_saved(Request $request)
    {
        $user_id = Session::get('user_data')->id;
        
        $input = $request->all();
    
		$rules['id'] = 'required';
		$messages['id.required']='Id is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $id=$request->id;
    	    $data = Save_event::where('user_id',$user_id)->where('event_id',$id)->get()->first();
            if(!empty($data))
            {
                $data = Save_event::find($data['id']);
                $data->user_id=$user_id;
				$data->event_id=$id;
				$data->save();
            }else{
			    $ins=new Save_event;
			    $ins->user_id=$user_id;
				$ins->event_id=$id;
				$ins->save();
            }
            $json_data['status']=1;
    		$json_data['message']	= 'Event saved successfully.';
    		echo json_encode($json_data);
    		exit;
    	}else{
    	    $json_data['status']=0;
    		$json_data['message']	= 'Something went wrong.';
    		echo json_encode($json_data);
    		exit;
    	}
    }
    public function event_unsaved(Request $request)
    {
        $user_id = Session::get('user_data')->id;
        
        $input = $request->all();
    
		$rules['id'] = 'required';
		$messages['id.required']='Id is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $id=$request->id;
    	    $data = Save_event::where('user_id',$user_id)->where('event_id',$id)->get()->first();
            if(!empty($data))
            {
                $data->delete();
            }
            $json_data['status']=1;
    		$json_data['message']	= 'Event unsaved successfully.';
    		echo json_encode($json_data);
    		exit;
    	}else{
    	    $json_data['status']=0;
    		$json_data['message']	= 'Something went wrong.';
    		echo json_encode($json_data);
    		exit;
    	}
    }
    public function event_confirm(Request $request)
    {
        $user_id = Session::get('user_data')->id;
        
        $input = $request->all();
    
		$rules['id'] = 'required';
		$messages['id.required']='Id is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $id=$request->id;
    	    $data = Users_event_status::where('user_id',$user_id)->where('event_id',$id)->get()->first();
            if(!empty($data))
            {
                $data1 = Users_event_status::find($data['id']);
                $data1->event_status=3;
				$data1->save();
            }else{
                $ins=new Users_event_status;
			    $ins->user_id=$user_id;
				$ins->event_id=$id;
				$ins->event_status=3;
				$ins->save();
            }
            $first_name=Session::get('user_data')->first_name;
          $last_name=Session::get('user_data')->last_name;
          $name=$first_name.' '.$last_name;
          $msg=$name.' staff member has accepted your event invitation';
            send_notification($user_id,0,$id,2,$msg,1,0);
            
            $json_data['status']=1;
    		$json_data['message']	= 'Event has been applied successfully.';
    		echo json_encode($json_data);
    		exit;
    	}else{
    	    $json_data['status']=0;
    		$json_data['message']	= 'Something went wrong.';
    		echo json_encode($json_data);
    		exit;
    	}
    }
    public function event_decline(Request $request)
    {
        $user_id = Session::get('user_data')->id;
        
        $input = $request->all();
    
		$rules['id'] = 'required';
		$messages['id.required']='Id is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $id=$request->id;
    	    $data = Users_event_status::where('user_id',$user_id)->where('event_id',$id)->get()->first();
            if(!empty($data))
            {
                $data1 = Users_event_status::find($data['id']);
                $data1->event_status=2;
				$data1->save();
            }else{
                $ins=new Users_event_status;
			    $ins->user_id=$user_id;
				$ins->event_id=$id;
				$ins->event_status=2;
				$ins->save();
            }
            
            $first_name=Session::get('user_data')->first_name;
            $last_name=Session::get('user_data')->last_name;
            $name=$first_name.' '.$last_name;
            $msg=$name.' staff member has declined your event invitation';
            send_notification($user_id,0,$id,3,$msg,1,0);
            
            $json_data['status']=1;
    		$json_data['message']	= 'Event has been declined successfully.';
    		echo json_encode($json_data);
    		exit;
    	}else{
    	    $json_data['status']=0;
    		$json_data['message']	= 'Something went wrong.';
    		echo json_encode($json_data);
    		exit;
    	}
    }
    public function get_event_by_filter(Request $request)
    { 
        $user_id = Session::get('user_data')->id;
        $type=$request->type;
        $eventdata = DB::table('users_event_status')
				->select('event.*','users_event_status.event_status','users_event_status.role as role_new')
				->leftJoin('event', 'users_event_status.event_id', '=', 'event.id')
				->where('users_event_status.user_id',$user_id);
		if($type == 'all'){ 
		    $eventdata->whereRaw('(users_event_status.event_status=1 or users_event_status.event_status=3 or users_event_status.event_status=5 or users_event_status.event_status=6 or users_event_status.event_status=7 or users_event_status.event_status=4)');
		}
		if($type==1)
		{
		    $eventdata->where('users_event_status.event_status',1);
		}
		if($type==3)
		{
		    $eventdata->where('users_event_status.event_status',3);
		}
		if($type==5)
		{
		    $eventdata->where('users_event_status.event_status',5);
		}
		if($type==6)
		{
		    $eventdata->where('users_event_status.event_status',6);
		}
		if($type==7)
		{
		    $eventdata->where('users_event_status.event_status',7);
		}
		if($type==4)
		{
		    $eventdata->where('users_event_status.event_status',4);
		}
		$eventdata->orderBy('event.start_date', 'desc');
		$event_data=$eventdata->get();
		
		
		$support_number='';
        $data_supp = Support_number::where('id',1)->get()->first();
        if(!empty($data_supp))
        {
            $support_number=$data_supp['support_number'];
           
        }
		
		$html_event_data=view('get_event_by_filter',['event_data'=>$event_data,'support_number'=>$support_number])->render();
		
		$json_data['status']=1;
		$json_data['html_event_data']=$html_event_data;
		$json_data['message']	= '';
		echo json_encode($json_data);
		exit;
    }
    public function get_event_shift_by_filter(Request $request)
    { 
        $user_id = Session::get('user_data')->id;
        $type=$request->type;
        $eventdata = DB::table('users_event_status')
				->select('event.*','users_event_status.event_status','users_event_status.role as role_new')
				->leftJoin('event', 'users_event_status.event_id', '=', 'event.id')
				->where('users_event_status.user_id',$user_id);
			if($type == 'all'){  
		        $eventdata->whereRaw('(users_event_status.event_status=7 or users_event_status.event_status=6 or users_event_status.event_status=5 or users_event_status.event_status=2)');
			}
			if($type==6)
    		{
    		    $eventdata->where('users_event_status.event_status',6);
    		}
    		if($type==7)
    		{
    		    $eventdata->where('users_event_status.event_status',7);
    		}
    		if($type==5)
    		{
    		    $eventdata->where('users_event_status.event_status',5);
    		}
    		if($type==2)
    		{
    		    $eventdata->where('users_event_status.event_status',2);
    		}
    	if(!empty($request->sort)){
    	    if($request->sort=='asc')
    	    {
    	        $eventdata->orderBy('event.name', 'ASC');
    	    }
    	    if($request->sort=='desc')
    	    {
    	        $eventdata->orderBy('event.name', 'DESC');
    	    }
    	    if($request->sort=='newest')
    	    {
    	        $eventdata->orderBy('event.id', 'ASC');
    	    }
    	    if($request->sort=='oldest')
    	    {
    	        $eventdata->orderBy('event.id', 'DESC');
    	    }
    	    if($request->sort=='start')
    	    {
    	        $eventdata->orderBy('event.start_date', 'ASC');
    	    }
    	    if($request->sort=='end')
    	    {
    	        $eventdata->orderBy('event.start_date', 'DESC');
    	    }
    	}else{
    	     $eventdata->orderBy('event.start_date', 'DESC');
    	}
		$event_data=$eventdata->get();
		
		$html_event_data=view('get_event_shift_by_filter',['event_data'=>$event_data])->render();
		
		$json_data['status']=1;
		$json_data['html_event_data']=$html_event_data;
		$json_data['message']	= '';
		echo json_encode($json_data);
		exit;
    }
    public function clock_in(Request $request)
    {
        $user_id = Session::get('user_data')->id;
        
        $input = $request->all();
    
		$rules['event_id'] = 'required';
		$messages['event_id.required']='Event Id is required';
		
		$rules['clock_in'] = 'required';
		$messages['clock_in.required']='Clock In is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $event_id=$request->event_id;
    	    $clock_in=$request->clock_in;
    	    $clock_in = preg_replace('/\s\(.+\)$/', '', $clock_in);
    	    
    	    $clock_in_explanatory_note=$request->clock_in_explanatory_note;
    	    $clock_in_date = Carbon::parse($clock_in)->format('Y-m-d');
    	    $clock_in_time = Carbon::parse($clock_in)->format('H:i:s');
    	    $clock_in_date_time = Carbon::parse($clock_in)->format('Y-m-d H:i:s');
    	    
    	    $check = Users_shift::where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->where('clock_in_date', $clock_in_date) 
                ->first();
    	    if($check){
    	        $data_upd = Users_shift::find($check['id']);
                $data_upd->clock_in_date=$clock_in_date;
    			$data_upd->clock_in_time=$clock_in_time;
    			$data_upd->clock_in_date_time=$clock_in_date_time;
    			$data_upd->clock_in_explanatory_note=$clock_in_explanatory_note;
    			$data_upd->save();
    	    }else{
        	    $ins=new Users_shift;
    		    $ins->user_id=$user_id;
    			$ins->event_id=$event_id;
    			$ins->clock_in_date=$clock_in_date;
    			$ins->clock_in_time=$clock_in_time;
    			$ins->clock_in_date_time=$clock_in_date_time;
    			$ins->clock_in_explanatory_note=$clock_in_explanatory_note;
    			$ins->save();
    	    }
			
			$data_shift = Users_shift::where('user_id',$user_id)->where('event_id',$event_id)->get();
            $totalMinutes = 0;

            foreach($data_shift as $shift) {
                if($shift->clock_in_date_time && $shift->clock_out_date_time) {
                    
                    $seconds = Carbon::parse($shift->clock_in_date_time)
                                ->diffInSeconds($shift->clock_out_date_time);
            
                    $totalMinutes += ceil($seconds / 60); // round up
                }
            }
            
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;
            
            $total_hours = sprintf('%02d:%02d', $hours, $minutes);
            
    		$html_shift_data=view('get_event_shift_detail_by_filter',['data_shift'=>$data_shift])->render();
			
			$json_data['status']=1;
    		$json_data['message']	= 'Clock in has been added successfully.';
    		$json_data['html_shift_data']=$html_shift_data;
		    $json_data['total_hours']=$total_hours;
    		echo json_encode($json_data);
    		exit;
    	}else{
    	    $json_data['status']=0;
    		$json_data['message']	= 'Something went wrong.';
    		echo json_encode($json_data);
    		exit;
    	}
    }
    public function clock_out(Request $request)
    {
        $user_id = Session::get('user_data')->id;
        
        $input = $request->all();
    
		$rules['event_id'] = 'required';
		$messages['event_id.required']='Event Id is required';
		
		$rules['clock_out'] = 'required';
		$messages['clock_out.required']='Clock In is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    try {
    	    $event_id=$request->event_id;
    	    $clock_out=$request->clock_out;
    	    
    	    $clock_out = preg_replace('/\s\(.+\)$/', '', $clock_out);
    	    
    	    $clock_out_explanatory_note=$request->clock_out_explanatory_note;
    	  
    	    $clock_out_date = Carbon::parse($clock_out)->format('Y-m-d');
    	    $clock_out_time = Carbon::parse($clock_out)->format('H:i:s');
    	    $clock_out_date_time = Carbon::parse($clock_out)->format('Y-m-d H:i:s');
    	    
    	    $data = Users_shift::where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->whereNull('clock_out_date') 
                ->orderBy('id', 'DESC') // last record mate
                ->first();
            
            if (!empty($data)) {
                
                    $data_upd = Users_shift::find($data['id']);
                    $data_upd->clock_out_date=$clock_out_date;
                    $data_upd->clock_out_time=$clock_out_time;
                    $data_upd->clock_out_date_time=$clock_out_date_time;
                    $data_upd->clock_out_explanatory_note=$clock_out_explanatory_note;
    				$data_upd->save();
    				
    				$data_shift = Users_shift::where('user_id',$user_id)->where('event_id',$event_id)->get();
		
            		$totalMinutes = 0;
            
                    foreach($data_shift as $shift) {
                        if($shift->clock_in_date_time && $shift->clock_out_date_time) {
                            
                            $seconds = Carbon::parse($shift->clock_in_date_time)
                                        ->diffInSeconds($shift->clock_out_date_time);
                    
                            $totalMinutes += ceil($seconds / 60); // round up
                        }
                    }
                    
                    $hours = floor($totalMinutes / 60);
                    $minutes = $totalMinutes % 60;
                    
                    $total_hours = sprintf('%02d:%02d', $hours, $minutes);
            		
            		
            		$html_shift_data=view('get_event_shift_detail_by_filter',['data_shift'=>$data_shift])->render();
    				
                    
                    $json_data['status']=1;
            		$json_data['message']	= 'Clock out has been added successfully.';
            		$json_data['html_shift_data']=$html_shift_data;
		            $json_data['total_hours']=$total_hours;
            		echo json_encode($json_data);
            		exit;
                
            }else{
                
                $data_des = Users_shift::where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->orderBy('id', 'DESC') // last record mate
                ->first();
                    if (!empty($data_des)) {
                            $data_upd = Users_shift::find($data_des['id']);
                            $data_upd->clock_out_date=$clock_out_date;
                            $data_upd->clock_out_time=$clock_out_time;
                            $data_upd->clock_out_date_time=$clock_out_date_time;
                            $data_upd->clock_out_explanatory_note=$clock_out_explanatory_note;
            				$data_upd->save();
            				
            				$data_shift = Users_shift::where('user_id',$user_id)->where('event_id',$event_id)->get();
        		
                    		$totalMinutes = 0;
                    
                            foreach($data_shift as $shift) {
                                if($shift->clock_in_date_time && $shift->clock_out_date_time) {
                                    
                                    $seconds = Carbon::parse($shift->clock_in_date_time)
                                                ->diffInSeconds($shift->clock_out_date_time);
                            
                                    $totalMinutes += ceil($seconds / 60); // round up
                                }
                            }
                            
                            $hours = floor($totalMinutes / 60);
                            $minutes = $totalMinutes % 60;
                            
                            $total_hours = sprintf('%02d:%02d', $hours, $minutes);
                    		
                    		
                    		$html_shift_data=view('get_event_shift_detail_by_filter',['data_shift'=>$data_shift])->render();
            				
                            
                            $json_data['status']=1;
                    		$json_data['message']	= 'Clock out has been added successfully.';
                    		$json_data['html_shift_data']=$html_shift_data;
        		            $json_data['total_hours']=$total_hours;
                    		echo json_encode($json_data);
                    		exit;
                    }else{
                         $json_data['status']=0;
                		$json_data['message']	= 'You have already clocked out for this event.';
                		echo json_encode($json_data);
                		exit;
                    }
            }
    	    } catch (\Exception $e) {
    	        $json_data['status']=0;
        		$json_data['message']	= 'Server error: ' . $e->getMessage();
        		echo json_encode($json_data);
        		exit;
            }
    	}else{
    	    $json_data['status']=0;
    		$json_data['message']	= 'All fields are required.';
    		echo json_encode($json_data);
    		exit;
    	}
    }
    public function get_event_shift_detail_by_filter(Request $request)
    { 
        $user_id = Session::get('user_data')->id;
        $event_id=$request->event_id;
		
		$data_shift = Users_shift::where('user_id',$user_id)->where('event_id',$event_id)->get();
		
		$totalMinutes = 0;

        foreach($data_shift as $shift) {
            if($shift->clock_in_date_time && $shift->clock_out_date_time) {
                
                $seconds = Carbon::parse($shift->clock_in_date_time)
                            ->diffInSeconds($shift->clock_out_date_time);
        
                $totalMinutes += ceil($seconds / 60); // round up
            }
        }
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        $total_hours = sprintf('%02d:%02d', $hours, $minutes);
		
		
		$html_shift_data=view('get_event_shift_detail_by_filter',['data_shift'=>$data_shift])->render();
		
		$user_shift = Users_shift::where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->whereDate('clock_in_date', date('Y-m-d'))
            ->whereNotNull('clock_out_date')
            ->first();
		$shift_check=0;
		if(!empty($user_shift))
		{
		    $shift_check=1;
		}
		
		$json_data['status']=1;
		$json_data['html_shift_data']=$html_shift_data;
		$json_data['total_hours']=$total_hours;
		$json_data['shift_check']=$shift_check;
		$json_data['message']	= '';
		echo json_encode($json_data);
		exit;
    }
    public function delete_account(Request $request)
    { 
        $reason=$request->reason;
        $user_id = Session::get('user_data')->id;
        
        $data_user=User::where('id',$user_id)->get()->first();
		if(!empty($data_user))
		{
		    $data=User::find($user_id);
    		$data->soft_delete=1;
    		$data->delete_account_reason=$reason;
    		if($data->save())
    		{
    		    $first_name=Session::get('user_data')->first_name;
                $last_name=Session::get('user_data')->last_name;
                $name=$first_name.' '.$last_name;
                $msg=$name.'  staff member has requested to close their account.';
                send_notification($user_id,0,0,4,$msg,1,0);
    		    
    		    $request->session()->flush();
   	   	        $json_data['status']=1;
        		$json_data['message']	= 'Account deleted successfully.';
        		echo json_encode($json_data);
        		exit;
    			
    		}else{
    			$json_data['status']=0;
        		$json_data['message']	= 'Account deleted fail.';
        		echo json_encode($json_data);
        		exit;
    		}
		}else{
		    $json_data['status']=0;
    		$json_data['message']	= 'No record found.';
    		echo json_encode($json_data);
    		exit;
		}
    }
    public function cron(Request $request)
    {
        
        $date = date('Y-m-d');
    
        // =========================
        // ONGOING EVENTS
        // =========================
        $ongoingEventIds = Event::where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->where('cron_ongoing_status', 0)
            ->pluck('id');
    
        if ($ongoingEventIds->isNotEmpty()) {
    
            // update status (5 → 6)
            Users_event_status::whereIn('event_id', $ongoingEventIds)
                ->where('event_status', 5)
                ->update(['event_status' => 6]);
    
            // mark events processed
            Event::whereIn('id', $ongoingEventIds)
                ->update(['cron_ongoing_status' => 1]);
        }
    
        // =========================
        // COMPLETED EVENTS
        // =========================
        $completedEventIds = Event::where('end_date', '<', $date)
            ->where('cron_completed_status', 0)
            ->pluck('id');
    
        if ($completedEventIds->isNotEmpty()) {
    
            // update status (6 → 7)
            Users_event_status::whereIn('event_id', $completedEventIds)
                ->where('event_status', 6)
                ->update(['event_status' => 7]);
    
            // mark events processed
            Event::whereIn('id', $completedEventIds)
                ->update(['cron_completed_status' => 1]);
        }
        
        
        // =========================
        // Shift Clock out auto
        // =========================
        
        /*$shif_clock_out_auto = Event_shift::where("status", 1)
    ->whereHas('event', function ($q) {
        $q->where('start_date', '<=', date("Y-m-d"));
        $q->where('end_date', '>=', date("Y-m-d"));
    })
    ->get();

        foreach ($shif_clock_out_auto as $key => $val) {
        
            // current time check
            if ($val->end_time < date("H:i:s")) {
        
                $today_date = date('Y-m-d');
        
                // explode user ids
                $arr_user = !empty($val->users_event_status_id) 
                    ? explode(",", $val->users_event_status_id) 
                    : [];
        
                if (!empty($arr_user)) {
        
                    $data_shift = Users_shift::where('event_id', $val->event_id)
                        ->whereIn('user_id', $arr_user)
                        ->where('clock_in_date', $today_date)
                        ->whereNull('clock_out_date') // better than ''
                        ->get();
        
                    foreach ($data_shift as $key1 => $val1) {
        
                        $clock_out_date_time = $today_date . ' ' . $val->end_time;
                        $clock_out_date_time = date("Y-m-d H:i:s", strtotime($clock_out_date_time));
        
                        $data = Users_shift::find($val1->id);
        
                        if ($data) {
                            $data->clock_out_date = $today_date;
                            $data->clock_out_time = $val->end_time;
                            $data->clock_out_date_time = $clock_out_date_time;
                            $data->save();
                        }
                    }
                }
            }
        }*/
        // =========================
        // Shift reminder Start
        // =========================
        $shif_clock_out_auto = Event_shift::where("status", 1)
            ->whereHas('event', function ($q) {
                $q->where('start_date', '<=', date("Y-m-d"))
                  ->where('end_date', '>=', date("Y-m-d"));
            })
            ->get();
        foreach ($shif_clock_out_auto as $shift) {
            // shift start datetime
            $shift_date = date("Y-m-d") . ' ' . $shift->start_time;
            $shift_date = date("Y-m-d H:i", strtotime($shift_date));
        
            // current time + 5 minutes
            $today_date = date("Y-m-d H:i", strtotime("+5 minutes"));
        
            if ($shift_date === $today_date) {
        
                if (!empty($shift->users_event_status_id)) {
        
                    $userIds = explode(",", $shift->users_event_status_id);
        
                    foreach ($userIds as $userId) {
        
                        $msg = "You have a shift starting in 5 minutes. Don’t forget to clock at your assigned shift start time.";
                        send_notification(0,$userId,$shift->event,9,$msg,0,0);
                        
                        $url=route('dashboard');
                        
                        send_noti_fcm('Shift reminder', $msg, $userId,$url);
                    }
                }
            }
        }
        
        // =========================
        // Shift reminder End
        // =========================
        
        $shif_clock_out_auto = Event_shift::where("status", 1)
            ->whereHas('event', function ($q) {
                $q->where('start_date', '<=', date("Y-m-d"))
                  ->where('end_date', '>=', date("Y-m-d"));
            })
            ->get();
        
        foreach ($shif_clock_out_auto as $shift) {
        
            // shift end datetime
            $shift_date = date("Y-m-d") . ' ' . $shift->end_time;
            $shift_date = date("Y-m-d H:i", strtotime($shift_date));
        
            // current time + 5 minutes
            $today_date = date("Y-m-d H:i", strtotime("+5 minutes"));
        
            if ($shift_date == $today_date) {
        
                if (!empty($shift->users_event_status_id)) {
        
                    $userIds = explode(",", $shift->users_event_status_id);
        
                    foreach ($userIds as $userId) {
        
                        $msg = "Your shift has just ended. Don’t forget to clock out.";
                        send_notification(0,$userId,$shift->event,10,$msg,0,0);
                        
                        $url=route('dashboard');
                        
                        send_noti_fcm('Shift reminder',$msg,$userId,$url);
                    }
                }
            }
        }
        
        
    }
    public function cron_day(Request $request)
    {
        
    
        $date = date('Y-m-d', strtotime('-1 day'));
    
        $data_user = User::whereDate('expiry_date', $date)->get();
    
        foreach ($data_user as $val) {
            if (!empty($val->id)) {
                
                $email= $val->email;
                $name=$val->first_name.' '.$val->last_name;
				$data_val = array('name'=>$name);
				  
				  Mail::send('document_expired', $data_val, function ($message) use ($email) { 
                    $message->to($email)
                        ->subject('Document Expired')
                        ->from(config('mail.from.address'), config('mail.from.name'));
                });
            }
        }
        
        if (date('N') == 1) {
            $mondayDate = date('Y-m-d');

            // Previous Sunday (last 7 days)
            $previousMonday = date('Y-m-d', strtotime('-7 days'));
            
            $data = Users_shift::with('user')
                ->whereBetween('clock_in_date', [$previousMonday, $mondayDate])
                ->select('user_id')
                ->distinct()
                ->get();
                
            foreach($data as $key=>$val){
                if($val->user)
                {
                    if($val->user->pps_number=='')
                    {
                        $email= $val->user->email;
                        $name=$val->user->first_name.' '.$val->user->last_name;
        				$data_val = array('name'=>$name);
        				  
        				  Mail::send('missing_payroll_data', $data_val, function ($message) use ($email) { 
                            $message->to($email)
                                ->subject('Missing payroll data')
                                ->from(config('mail.from.address'), config('mail.from.name'));
                        });
                    }else{
                        $data_bank = Bank_account_details::where('user_id', $val->user_id)->get()->first();
                        if(empty($data_bank))
                        {
                            $email= $val->user->email;
                            $name=$val->user->first_name.' '.$val->user->last_name;
            				$data_val = array('name'=>$name);
            				  
            				  Mail::send('missing_payroll_data', $data_val, function ($message) use ($email) { 
                                $message->to($email)
                                    ->subject('Missing payroll data')
                                    ->from(config('mail.from.address'), config('mail.from.name'));
                            });
                        }
                    }
                }
            }
        }
        
        
    }
    public function book_annual_leave(Request $request)
    {
        $user_id = Session::get('user_data')->id;
        
        $eligible_leave_hours=$request->eligible_leave_hours;
        $eligible=$request->eligible;
        
        $ins=new Annual_leave;
	    $ins->user_id=$user_id;
		$ins->date=date('Y-m-d');
		$ins->hours_worked=$eligible_leave_hours;
		$ins->annual_leave=$eligible;
		$ins->status=0;
		if($ins->save())
    	{
    	    $first_name=Session::get('user_data')->first_name;
            $last_name=Session::get('user_data')->last_name;
            $name=$first_name.' '.$last_name;
            $msg=$name.' staff member has submitted a leave or holiday request.';
            send_notification($user_id,0,0,4,$msg,1,0);
    	    
    	    $json_data['status']=1;
    		$json_data['message']	= 'Annual Leave added successfully.';
    		echo json_encode($json_data);
    		exit;
    	}else{
    	    $json_data['status']=0;
    		$json_data['message']	= 'Annual Leave added fail.';
    		echo json_encode($json_data);
    		exit;
    	}
    }
    public function view_shift_detail(Request $request)
    { 
        if(!empty($request->id))
        {
            $event_id=$request->id;
            $data_event = Event::where('id',$event_id)->get()->first();
            if(!empty($data_event))
            {
                $menu = 'shift-detail';
                $user_id = Session::get('user_data')->id;
               
               
                return view('view_shift_detail', ['page' => $menu,'data_event'=>$data_event]);
            }else{
                return redirect('my_events');
            }
        }else{
            return redirect('my_events');
        }
    }
    public function do_pps_number(Request $request)
    {
        $id = Session::get('user_data')->id;
        $pps_number=$request->pps_number;
        
        $data = User::find($id);
        $data->pps_number=$pps_number;
    	$data->save();
        
        
        $json_data['status'] = 1;
        $json_data['message']    = 'PPS Number has been updated.';
        echo json_encode($json_data);
        exit;
    }
    public function logout(Request $request)
    {
		$request->session()->flush();
   	   	return redirect('login');
	}
}
