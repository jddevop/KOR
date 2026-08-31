<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;
use DB;
use Hash;
use Session;
use Mail;
use Illuminate\Support\Facades\Cookie;
class LoginController extends Controller
{
    public function index()
    { 
		return view('admin.login');
	}
	public function login(Request $request)
    {
		$input = $request->all();
			
		$rules['email'] = 'required|email';
		$messages['email.required']='Email is required';
		
		$rules['password'] = 'required';
		$messages['password.required']='Password is required';
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$admin = DB::table('admins')
			->where('email', $request->email)
			->get()->first();
			
			$total = count((array)$admin);
			if($total > 0)
			{
			
				if (Hash::check($request->password, $admin->password)) {
					Session::put('admin_data', $admin);
					session()->save();
					
					$remember = $request->has('remember');
					if ($remember) {
                        Cookie::queue('remember_email', $request->email, 43200); // 30 days
                        Cookie::queue('remember_password', $request->password, 43200);
                    } else {
                        Cookie::queue(Cookie::forget('remember_email'));
                        Cookie::queue(Cookie::forget('remember_password'));
                    }
					return redirect('admin/dashboard');
					
					exit;
				}else{
					return redirect('admin/login')->with('danger', 'Wrong email and password.');	
				}
				 
			}else{
				return redirect('admin/login')->with('danger', 'Wrong email and password.');	
			}
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}
	}
	public function forgot_password()
    { 
		return view('admin.forgot_password');
	}
	public function reset_link(Request $request)
    { 
		$input = $request->all();
			
		$rules['email'] = 'required|email';
		$messages['email.required']='Email is required';
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$admin = DB::table('admins')
			->where('email', $request->email)
			->get()->first();
			
			$total = count((array)$admin);
			if($total > 0)
			{
			    try {
				$token=rand(1000000,9999999);
				$updated=DB::update('update admins set remember_token="'.$token.'" where id=?',[$admin->id]); 
				$email= $admin->email;
			 
				 $data = array('token'=>$token);
				  
				  
				  Mail::send('admin.forgot_password_mail', $data, function ($message) use ($email) { 
                    $message->to($email)
                        ->subject('Reset Password')
                        ->from(config('mail.from.address'), config('mail.from.name'));
                });
				  
				  return redirect('admin/forgot_password')->with('success','Email sent successfully. Check Your Mail...');
			    } catch (\Exception $e) {
                
                    return back()->with('danger', 'Mail not sent. Please try again.');
                }
			}else{
				return redirect('admin/forgot_password')->with('danger','Error :Email does not Exist...!');	
			}
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}
	}
	public function reset_password($token)
    { 
		$row = DB::table('admins')
		->where('remember_token', $token)
		->get()->first();
		
		$total = count((array)$row);
		if($total > 0)
		{
			$data['token']=$token;
			return view('admin.reset_password')->with($data);	
		}else{
			return redirect('admin/login')->with('danger','Error :Try Again...Your key is invalid or expired.');	
		}
	}
	public function reset_password_update(Request $request)
    {
		$request->validate([
            'password' => 'required|string',
            'cpassword' => 'required|string|same:password',
        ],[
    		'password.required' => 'Password is required',
			'cpassword.required' => 'Comfirm Password is required',
			'cpassword.same' => 'Password and Comfirm password not match',
			]);
		$password = $request->password;
        $cpassword = $request->cpassword;
		$token = $request->token;
		$row = DB::table('admins')
		->where('remember_token', $token)
		->get()->first();
		
		$total = count((array)$row);
		if($total > 0)
		{
			$token1='';
			$npassword = Hash::make($password);
			$updated=DB::update('update admins set remember_token="'.$token1.'",password="'.$npassword.'" where id=?',[$row->id]);
			return redirect('admin/login')->with('success','Password change successfully !');;
		}else{
			return redirect('admin/reset_password/'.$token)->with('error','Error :Try Again...Your key is invalid or expired.');
		}
	}
}
