<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Tags;
use App\Models\Occupations;
use App\Models\English_level;
use App\Models\Experience_level;
use App\Models\Bank_account_details;
use App\Models\Notification;
use App\Models\Users_shift;
use Validator;
use DB;
use Session;
use Hash;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $main_menu='users';
		$sub_menu='users';
	
        $view_data=User::orderBy('id', 'desc')->get();
		
		$tags_data=Tags::where('status',1)->get();
             
        $english_level_data = English_level::where('status', 1)->get();
              
        $occupations_data = Occupations::where('status', 1)->get();
        
        $experience_data = Experience_level::where('status', 1)->get();
		
        return view('admin.view_users',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'view_data' => $view_data,'tags_data'=>$tags_data,'english_level_data'=>$english_level_data,'occupations_data'=>$occupations_data,'experience_data'=>$experience_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $main_menu='users';
		$sub_menu='users'; 
	    $mode='Add';		
		return view('admin.add_users',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'mode'=>$mode]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $main_menu='users';
		$sub_menu='users';
		$data=User::find($id);
		if(!empty($data))
		{
		    $bank_data=array();
		    $datab = Bank_account_details::where('user_id',$id)->get()->first();
            if(!empty($datab))
            {
                $bank_data['account_holder_name']=$datab['account_holder_name'];
                $bank_data['home_address']=$datab['home_address'];
                $bank_data['iban']=$datab['iban'];
                $bank_data['bank_address']=$datab['bank_address'];
            }
            
            $arr_exp = !empty($data['area_experience_occupations_id']) 
                ? explode(',', $data['area_experience_occupations_id']) 
                : [];
            
            $occupations_arr = Occupations::whereIn('id', $arr_exp)->get();
            
    
        $eventList = Users_shift::where('user_id', $id)->select('event_id')->groupBy('event_id')->get();

        $totalEvents = $eventList->count();
            $last_event_name='-';
            $eventLast = Users_shift::where('user_id', $id)->orderBy('id', 'desc')->get()->first();
            if(!empty($eventLast))
            {
                if($eventLast->event)
                {
                    $last_event_name=$eventLast->event->name;
                }
            }
            
			return view('admin.show_users',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'data' => $data,'bank_data'=>$bank_data,'occupations_arr'=>$occupations_arr,'totalEvents'=>$totalEvents,'last_event_name'=>$last_event_name]);
		}else{
			return redirect('users');
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$row_img=User::find($id);
		$image_path = base_path("public/upload/users/".$row_img->profile_picture); 
		
        $data = User::find($id); 
        if($data->delete()){   
			if(File::exists($image_path)) {
				File::delete($image_path);
			} 
			
            $result = array('status' => true, 'message' => 'Success!', 'result' => '');
        }else{
          $result = array('status' => false, 'message' => 'Fail!', 'result' => '');  
        }
        echo json_encode($result);
        exit;
    }
	public function get_employer(Request $request)
    {
        $id=$request->id;
        $user = User::find($id); 
        $data=array();
        if($user) {
            $data = [
                    'employer_name'   => $user->employer_name,   
                    'employer_number' => $user->employer_number,
                    'email'           => $user->employer_email,
                    'contact_number'  => $user->employer_contact_number
                ];
        }
        $json_data['status'] = 1;
		$json_data['message']    ='';
		$json_data['data']    =$data;
		echo json_encode($json_data);
		exit;
        
    }
    public function add_employer(Request $request)
    {
        $input = $request->all();
    
        $rules['id'] = 'required';
		$messages['id.required']='Id is required';
    
		$rules['employer_name'] = 'required';
		$messages['employer_name.required']='Employer Name is required';

		$rules['employer_number'] = 'required';
		$messages['employer_number.required']='Employer Number is required';

		$rules['employer_contact_number'] = 'required';
		$messages['employer_contact_number.required']='Employer Contact Number is required';
		
		$rules['employer_email'] = 'required|email';
		$messages['employer_email.required']='Email is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $id=$request->id;
		    $employer_name=$request->employer_name;
		    $employer_number=$request->employer_number;
		    $employer_contact_number=$request->employer_contact_number;
		    $employer_email=$request->employer_email;
		    
		    $data = User::find($id);
			$data->employer_name=$employer_name;
			$data->employer_number=$employer_number;
			$data->employer_contact_number=$employer_contact_number;
			$data->employer_email=$employer_email;
			if($data->save())
			{
                $json_data['status'] = 1;
                $json_data['message']    = 'Employer has been updated.';
                echo json_encode($json_data);
                exit;
			}else{
			    $json_data['status'] = 0;
				$json_data['message']    = 'Employer updated fail.';
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
    public function add_user_tags(Request $request)
    {
        $user_id = $request->user_id;
        $tags_ids = $request->tags_id;
    
        $user = User::find($user_id);
    
        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'User not found!'
            ]);
        }
        $user->tags_id = $tags_ids; // comma separated store
        $user->save();
    
        return response()->json([
            'status' => 1,
            'message' => 'Tags added successfully!'
        ]);
    }
    public function get_tags(Request $request)
    {
        $user_id = $request->user_id;
    
        $user = User::find($user_id);
    
        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'User not found!'
            ]);
        }
    
        // Safe explode
        $tags_id = !empty($user->tags_id) ? explode(',', $user->tags_id) : [];
    
        $tags_data = Tags::where('status', 1)->get();
    
        $html = '';
    
        foreach ($tags_data as $val) {
    
            $selected = in_array($val->id, $tags_id) ? 'selected' : '';
    
            $html .= '<option value="' . $val->id . '" ' . $selected . '>' . $val->name . '</option>';
        }
    
        return response()->json([
            'status' => 1,
            'html'   => $html,
            'message'=> ''
        ]);
    }
    public function get_search_users(Request $request)
    {
        $query=User::orderByRaw("CONCAT(IFNULL(first_name,''), ' ', IFNULL(last_name,'')) ASC");
        // Tags
        if(!empty($request->tags_id)){
            $query->where(function($q) use ($request){
                foreach($request->tags_id as $tag){
                    $q->orWhereRaw("FIND_IN_SET(?, tags_id)", [$tag]);
                }
            });
        }
    
        // English Level
        if(!empty($request->english_level_id)){
            $query->where('english_level_id', $request->english_level_id);
        }
        
        // Occupation
        if(!empty($request->area_experience_occupations_id)){
            $query->whereRaw(
                "FIND_IN_SET(?, area_experience_occupations_id)", 
                [$request->area_experience_occupations_id]
            );
        }
        
        // Experience Level
        if(!empty($request->experience_level_id)){
            $query->where('experience_level_id', $request->experience_level_id);
        }
        
        //  SEARCH (First + Last + Email)
        if(!empty($request->search_val)){
            $search = trim($request->search_val);
            $search_phone = str_replace('+', '', $search);
            $query->where(function($q) use ($search,$search_phone){
                $q->where('first_name', 'LIKE', "{$search}%")
                  ->orWhere('last_name', 'LIKE', "{$search}%")
                  ->orWhere('email', 'LIKE', "{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["{$search}%"])
                  ->orWhere('phone_text', 'LIKE', "{$search_phone}%");
            });
        }
        
        
        $view_data = $query->get();
        
        $html_data = view('admin.get_search_users', compact('view_data'))->render();
    
        return response()->json([
            'status' => 1,
            'html_data' => $html_data,
            'message' => ''
        ]);
    }
    public function export_user(Request $request)
    {
        $fileName = 'user.csv';
    
        $query=User::orderBy('id', 'desc');
        // Tags
        if(!empty($request->tags_id)){
            $query->where(function($q) use ($request){
                foreach($request->tags_id as $tag){
                    $q->orWhereRaw("FIND_IN_SET(?, tags_id)", [$tag]);
                }
            });
        }
    
        // English Level
        if(!empty($request->english_level_id)){
            $query->where('english_level_id', $request->english_level_id);
        }
        
        // Occupation
        if(!empty($request->area_experience_occupations_id)){
            $query->whereRaw(
                "FIND_IN_SET(?, area_experience_occupations_id)", 
                [$request->area_experience_occupations_id]
            );
        }
        
        // Experience Level
        if(!empty($request->experience_level_id)){
            $query->where('experience_level_id', $request->experience_level_id);
        }
        
        //  SEARCH (First + Last + Email)
        if(!empty($request->search_val)){
            $search = trim($request->search_val);
        
            $query->where(function($q) use ($search){
                $q->where('first_name', 'LIKE', "{$search}%")
                  ->orWhere('last_name', 'LIKE', "{$search}%")
                  ->orWhere('email', 'LIKE', "{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["{$search}%"]);
            });
        }
        
        $view_data = $query->get();
    
        $headers = [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate",
            "Expires"             => "0"
        ];
    
        $columns = [
            'Employee Id',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Gender',
            'Date of birth',
            'Nationality',
            'Where are you currently based',
            'Areas Experience',
            'Additional Experience',
            'How did you hear about us',
            'General Availability',
            'English Level',
            'How long have you been in Ireland',
            'PPS number',
            'IBAN',
            'Sort Code',
            'Bank Account Number',
        ];
    
        $callback = function () use ($view_data, $columns) {
    
            $file = fopen('php://output', 'w');
    
            // UTF-8 BOM (fix Excel issue)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
    
            fputcsv($file, $columns);
    
            foreach ($view_data as $val) {
                $employee_id='EMP-'.$val['employee_id'];
                
                $phone="+".$val['country_code'].' '.$val['phone'];
                
                $city='';
                if($val->city)
                {
                    $city=$val->city->name;
                }
                
                $english_level='';
                if($val->english_level)
                {
                    $english_level=$val->english_level->name;
                }
                $experience_level='';
                if($val->experience_level)
                {
                    $experience_level=$val->experience_level->name;
                }
                
                $arr_exp = !empty($val['area_experience_occupations_id']) 
                    ? explode(',', $val['area_experience_occupations_id']) 
                    : [];
                
                $occupations_arr = Occupations::whereIn('id', $arr_exp)->get();
                
                $occupations = '';
                
                if ($occupations_arr->count() > 0) {
                    $occupations = implode(',', $occupations_arr->pluck('name')->toArray());
                }
                
                $bank=get_users_bank_detail($val['id']);
                $bank_details=str_replace(' ', '', $bank);
                $sort_code=substr($bank, 8,6);
                $bank_account_number=substr($bank, 14);
                fputcsv($file, [
                    $employee_id,
                    $val['first_name'],
                    $val['last_name'],
                    $val['email'],
                    $phone,
                    $val['gender'],
                    $val['birth_date'],
                    $val['nationality'],
                    $city,
                    $occupations,
                    $val['additional_experience'],
                    $val['hear_about_us'],
                    $val['general_availability'],
                    $english_level,
                    $experience_level,
                    $val['pps_number'],
                    $bank_details,
                    $sort_code,
                    $bank_account_number
                ]);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=events.csv",
        ]);
    }
    public function add_user_notes(Request $request)
    {
        $input = $request->all();
    
        $rules['id'] = 'required';
		$messages['id.required']='Id is required';
    
		$rules['notes'] = 'required';
		$messages['notes.required']='Notes is required';

		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $id=$request->id;
		    $notes=$request->notes;
		    
		    $data = User::find($id);
			$data->notes=$notes;
			if($data->save())
			{
                $json_data['status'] = 1;
                $json_data['message']    = 'Notes has been updated.';
                echo json_encode($json_data);
                exit;
			}else{
			    $json_data['status'] = 0;
				$json_data['message']    = 'Notes updated fail.';
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
    public function get_notification(Request $request)
    {
        $noti_count = Notification::where('status', 0)->where('notification_type',1)->count();
        
        $noti_data = Notification::where('status', 0)->where('notification_type',1)->latest()->take(4)->get();
        
        $html_data = view('admin.get_notification',['noti_data'=>$noti_data,'noti_count'=>$noti_count] )->render();
        
        return response()->json([
            'status' => 1,
            'noti_count' => $noti_count,
            'html_data'=>$html_data,
            'message' => ''
        ]);
    }
}
