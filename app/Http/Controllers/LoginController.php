<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Session;
use Validator;
use Hash;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Models\City;
use App\Models\User;
use App\Models\Occupations;
use App\Models\English_level;
use App\Models\Experience_level;
use App\Models\Terms_of_employment;

class LoginController extends Controller
{
    public function login(Request $request)
    { 
        $menu = 'login';
        
        return view('login', ['page' => $menu]);
    }
    public function login_chk(Request $request)
    {
		$input = $request->all();

		$rules['email'] = 'required';
		$messages['email.required']='Email is required';

		$rules['password'] = 'required';
		$messages['password.required']='Password is required';

		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$user = DB::table('users')
			->where('email', $request->email)
			->get()->first();

			$total = count((array)$user);
			if($total > 0)
			{
				if(Hash::check($request->password, $user->password)) {
                if($user->soft_delete==0)
				{
					$user->login_type = 'user';
					Session::put('user_data', $user);
					session()->save();
                    if($request->token!=''){
						$data_upd=User::find($user->id);
						$data_upd->token=$request->token;
						$data_upd->save();
					}
					return redirect('dashboard');
				}else{
				    return redirect('login')->with('danger', 'No data found.');
				}
				}else{
					return redirect('login')->with('danger', 'Wrong password.');
				}
			}else{
				return redirect('login')->with('danger', 'Wrong email.');
			}
		}else{
				return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}
	}
    public function register(Request $request)
    { 
        $menu = 'login';

        $city_data = City::where('status', 1)
            ->where(function($q) {
                $q->where('nationality', 'Irish')
                  ->orWhere('sort', 1); // only Other
            })
            ->orderByRaw("
                CASE 
                    WHEN nationality = 'Irish' THEN 0
                    WHEN sort = 1 THEN 1
                END
            ")
            ->orderBy('name', 'ASC') // optional
            ->get();

        $english_level_data = English_level::where('status', 1)->orderBy('name', 'ASC') ->get();
        
        $occupations_data = Occupations::where('status', 1)->orderBy('name', 'ASC') ->get();
        
        $experience_level_data = Experience_level::where('status', 1)->orderBy('id', 'ASC') ->get();
        
        
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
        return view('register', ['page' => $menu,'city_data'=>$city_data,'english_level_data'=>$english_level_data,'occupations_data'=>$occupations_data,'experience_level_data'=>$experience_level_data,'dataemp'=>$dataemp]);
    }
    public function recover_password(Request $request)
    { 
        $menu = 'recover-password';

        return view('recover_password', ['page' => $menu]);
    }
    public function do_recover_password(Request $request)
    {
		$input = $request->all();
		$rules['email'] = 'required|email';
		$messages['email.required']='Email is required';
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$us_data = DB::table('users')
			->where('email', $request->email)
			->where('soft_delete',0)
			->get()->first();

			$total = count((array)$us_data);
			if($total > 0)
			{
				$token=rand(100000,999999);
				$name=$us_data->first_name.' '.$us_data->last_name;
				$email= $us_data->email;
				$data = array('token'=>$token,'name'=>$name);
				  
				  Mail::send('forgot_password_mail', $data, function ($message) use ($email) { 
                    $message->to($email)
                        ->subject('Reset Password')
                        ->from(config('mail.from.address'), config('mail.from.name'));
                });
                Session::put('user_otp', $token);
                Session::put('user_email', $email);
					session()->save();
			   return redirect('otp');  
			}else{
				return redirect('recover_password')->with('danger', "Wrong email");
			}
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}
	}
	public function resend_otp(Request $request)
    {
        if (Session::has('user_email')) {
        
		$input = $request->all();
		$email=Session::get('user_email');
			$us_data = DB::table('users')
			->where('email', $email)
			->where('soft_delete',0)
			->get()->first();

			$total = count((array)$us_data);
			if($total > 0)
			{
				$token=rand(100000,999999);
				$name=$user->name;
				$email= $us_data->email;
				$data = array('token'=>$token,'name'=>$name);
				  
				  Mail::send('forgot_password_mail', $data, function ($message) use ($email) { 
                    $message->to($email)
                        ->subject('Reset Password')
                        ->from(config('mail.from.address'), config('mail.from.name'));
                });
                Session::put('user_otp', $token);
                Session::put('user_email', $email);
					session()->save();
				
				$json_data['status']=1;
				$json_data['message']	= "OTP resent successfully.";
				echo json_encode($json_data);
				exit;
			  
			}else{
				$json_data['status']=0;
				$json_data['message']	= "We couldn't find this email address.";
				echo json_encode($json_data);
				exit;
			}
        }else{
            $json_data['status']=0;
				$json_data['message']	= 'Something is wrong.';
				echo json_encode($json_data);
				exit;
        }
		
	}
    public function otp(Request $request)
    { 
        if (Session::has('user_otp')) {
            $menu = 'otp';
            
            return view('otp', ['page' => $menu]);
        }else{
            return redirect('login')->with('danger', "Something is wrong.");
        }
    }
    public function otp_chk(Request $request)
    { 
        $input = $request->all();
		$rules['otp1'] = 'required';
		$messages['otp1.required']='Otp1 is required';
		
		$rules['otp2'] = 'required';
		$messages['otp2.required']='Otp2 is required';
		
		$rules['otp3'] = 'required';
		$messages['otp3.required']='Otp3 is required';
		
		$rules['otp4'] = 'required';
		$messages['otp4.required']='Otp4 is required';
		
		$rules['otp5'] = 'required';
		$messages['otp5.required']='Otp5 is required';
		
		$rules['otp6'] = 'required';
		$messages['otp6.required']='Otp6 is required';
		
		$validator = Validator::make($input, $rules,$messages);
		if($validator->passes()) { 
            $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;
            if(Session::get('user_otp')==$otp)
            {
                Session::put('user_otp_verify', 1);
                session()->save();
                return redirect('reset_password');
            }else{
                return redirect('otp')->with('danger', "Invalid OTP.");
            }
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}
    }
    public function reset_password(Request $request)
    { 
        if (Session::has('user_otp_verify')) {
            $menu = 'reset-password';
            return view('reset_password', ['page' => $menu]);
        }else{
            return redirect('otp')->with('danger', "Something is wrong.");
        }
    }
    public function do_reset_password(Request $request)
    {
        $input = $request->all();
        
         $validator = Validator::make($request->all(), [
                'password' => 'required|string',
                'cpassword' => 'required|string|same:password',
            ], [
                'password.required' => 'Password is required',
                'cpassword.required' => 'Confirm Password is required',
                'cpassword.same' => 'Password and Confirm Password do not match',
            ]);
            
		if ($validator->fails()) {
            $json_data['status']=0;
				$json_data['message']	= 'Something is wrong';
				echo json_encode($json_data);
				exit;
        }
		
		$password = $request->password;
        $cpassword = $request->cpassword;
		$email=Session::get('user_email');
		$row = DB::table('users')
		->where('email', $email)
		->where('soft_delete',0)
		->get()->first();
		
		$total = count((array)$row);
		if($total > 0)
		{
			$npassword = Hash::make($password);
			$updated=DB::update('update users set password="'.$npassword.'" where id=?',[$row->id]);
			
			Session::forget(['user_otp', 'user_email', 'user_otp_verify']);
            Session::save();
			$json_data['status']=1;
				$json_data['message']	= 'Password change successfully !';
				echo json_encode($json_data);
				exit;
			
		}else{
			    $json_data['status']=0;
				$json_data['message']	= 'Something is wrong';
				echo json_encode($json_data);
				exit;
		}
	}
	public function getcity(Request $request)
    { 
        $nationality = $request->nationality;
        
        
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
        
        $html='<option value="">Select city</option>';
        foreach($city_data as $key=>$val)
        {
           $html.='<option value="'.$val['id'].'">'.$val['name'].'</option>'; 
        }
        
        $json_data['status']=1;
		$json_data['message']	= '';
		$json_data['html']	= $html;
		echo json_encode($json_data);
		exit;
        
    }
    public function do_register(Request $request)
    {
		$input = $request->all();

		$rules['first_name'] = 'required';
		$messages['first_name.required']='First Name is required';

		$rules['last_name'] = 'required';
		$messages['last_name.required']='Last Name is required';

        $rules['email'] = 'required|email';
		$messages['email.required']='Email is required';
		
		$rules['phone'] = 'required';
		$messages['phone.required']='Phone is required';
		
		$rules['gender'] = 'required';
		$messages['gender.required']='Gender is required';
		
		$rules['birth_date'] = 'required';
		$messages['birth_date.required']='Birth Date is required';
	
		
		$rules['password'] = 'required';
		$messages['password.required']='Password is required';
		
		
		$rules['nationality'] = 'required';
		$messages['nationality.required']='Nationality is required';
		
		$rules['city_id'] = 'required';
		$messages['city_id.required']='City Id is required';
		
		if(empty($request->area_experience))
		{
		    $rules['area_experience'] = 'required';
		    $messages['area_experience.required']='Area Experience is required';
		}

        /*$rules['additional_experience'] = 'required';
		$messages['additional_experience.required']='Additional Experience is required';*/
		
		$rules['hear_about_us'] = 'required';
		$messages['hear_about_us.required']='Hear About Us is required';
		
		if(empty($request->general_availability))
		{
		    $rules['general_availability'] = 'required';
		    $messages['general_availability.required']='General Availability is required';
		}

        if($request->nationality=='EU')
		{
		    $rules['experience_level_id'] = 'required';
		    $messages['experience_level_id.required']='how long have you been in Ireland is required';
		    
		    $rules['english_level'] = 'required';
		    $messages['english_level.required']='English Level is required';
		    
		}else if($request->nationality=='Non-EU')
		{
		    $rules['experience_level_id'] = 'required';
		    $messages['experience_level_id.required']='how long have you been in Ireland is required';
		    
		    $rules['english_level'] = 'required';
		    $messages['english_level.required']='English Level is required';
		    
		    $rules['expiry_date'] = 'required';
		    $messages['expiry_date.required']='Expiry Date is required';
		}

		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
		     try {
    		    $first_name=$request->first_name;
    		    $last_name=$request->last_name;
    		    $email=$request->email;
    		    $phone=$request->phone;
    		    $country_code=$request->country_code;
    		    $country_short_code=$request->country_short_code;
    		    
    		    $phone_text=$country_code.$phone;
    		    $gender=$request->gender;
    		    $birth_date=$request->birth_date;
    		    $password=Hash::make($request->password);
    		    $nationality=$request->nationality;
    		    $city_id=$request->city_id;
    		    $area_experience = '';
                if (!empty($request->area_experience)) {
                    $area_experience = implode(',', $request->area_experience);
                }
    		    $additional_experience=$request->additional_experience;
    		    $hear_about_us=$request->hear_about_us;
    		    
    		    $general_availability = '';
                if (!empty($request->general_availability)) {
                    $general_availability = implode(',', $request->general_availability);
                }
    		    $experience_level_id=$request->experience_level_id;
    		    $english_level=$request->english_level;
    		    $pps_number=$request->pps_number;
    		    $expiry_date=$request->expiry_date;
    		    
    		    $view_data=User::where('email',$email)->where('soft_delete',0)->get()->first();
    			if(empty($view_data))
    			{
    			    $view_data_reg=User::where('email',$request->email)->where('soft_delete',1)->get()->first();
    				if(!empty($view_data_reg))
    				{ 
    				    $data_upd=User::find($view_data_reg['id']);
					    $data_upd->email=$view_data_reg['email'].'_deleted_'.time();
					    $data_upd->save();
    				}
    			    $ins=new User;
    				$ins->first_name=$first_name;
    				$ins->last_name=$last_name;
    				$ins->email=$email;
    				$ins->phone=$phone;
    				$ins->phone_text=$phone_text;
    				$ins->country_code=$country_code;
    				$ins->country_short_code=$country_short_code;
    				$ins->gender=$gender;
    				$ins->birth_date=date("Y-m-d",strtotime($birth_date));
    				$ins->password=$password;
    				$ins->nationality=$nationality;
    				$ins->city_id=$city_id;
    				$ins->password=$password;
    				$ins->area_experience_occupations_id=$area_experience;
    				$ins->additional_experience=$additional_experience;
    				$ins->hear_about_us=$hear_about_us;
    				$ins->general_availability=$general_availability;
    				$ins->pps_number=$pps_number;
    				if($nationality=='EU' || $nationality=='Non-EU')
        			{
    				    $ins->experience_level_id=$experience_level_id;
    				    $ins->english_level_id=$english_level;
        			}
    				if ($request->hasFile('profile_picture')) {
        				$image = $request->file('profile_picture');
        				$file_name =str_replace(" ","-",$image->getClientOriginalName());
        				$file_name=time().$file_name;
        				$destinationPath = base_path('public/upload/users');
        				$image->move($destinationPath, $file_name);
        				$ins->profile_picture=$file_name;
        			}
        			if($nationality=='Irish' || $nationality=='EU')
        			{
            			if ($request->hasFile('national_id')) {
            				$image = $request->file('national_id');
            				$file_name =str_replace(" ","-",$image->getClientOriginalName());
            				$file_name=time().'_national_'.$file_name;
            				$destinationPath = base_path('public/upload/users');
            				$image->move($destinationPath, $file_name);
            				$ins->national_id=$file_name;
            			}
        			}
        			if ($request->hasFile('cv')) {
        				$image = $request->file('cv');
        				$file_name =str_replace(" ","-",$image->getClientOriginalName());
        				$file_name=time().'_cv_'.$file_name;
        				$destinationPath = base_path('public/upload/users');
        				$image->move($destinationPath, $file_name);
        				$ins->cv=$file_name;
        			}
        			if($nationality=='Non-EU')
        			{
        			    $image = $request->file('permission_to_work1');
        				$file_name =str_replace(" ","-",$image->getClientOriginalName());
        				$file_name=time().'_permission1_'.$file_name;
        				$destinationPath = base_path('public/upload/users');
        				$image->move($destinationPath, $file_name);
        				$ins->permission_to_work1=$file_name;
        				
        				if ($request->hasFile('permission_to_work2')) {
        				
            				$image = $request->file('permission_to_work2');
            				$file_name =str_replace(" ","-",$image->getClientOriginalName());
            				$file_name=time().'_permission2_'.$file_name;
            				$destinationPath = base_path('public/upload/users');
            				$image->move($destinationPath, $file_name);
            				$ins->permission_to_work2=$file_name;
        				}
        				$ins->expiry_date=date("Y-m-d",strtotime($expiry_date));
        			}
    				if($ins->save())
    				{
    				    $last_id=$ins->id;
    				    $data = User::find($last_id);
                        $data->employee_id = $last_id;
                        $data->save();
                        
                        $json_data['status'] = 1;
                        $json_data['message']    = 'Register added successfully.';
                        echo json_encode($json_data);
                        exit;
    				}else{
    				    $json_data['status'] = 0;
    					$json_data['message']    = 'Sign up added fail.';
    					echo json_encode($json_data);
    					exit;
    				}
			}else{
			    $json_data['status'] = 0;
				$json_data['message']    = 'Already registered account with this email address.';
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
	}
}
