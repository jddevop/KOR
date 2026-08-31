<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Admin;
use App\Models\User;
use App\Models\Tags;
use App\Models\City;
use App\Models\Occupations;

use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
class DashboardController extends Controller
{
    public function index()
    { 
        //$url=route('dashboard');
        //$res=send_noti_fcm('KOR Event1','This is test description1',1,$url);
        //exit;
		$main_menu='dashboard';
		$sub_menu='dashboard';
		
		$userlist = User::get();
		$userCount = $userlist->count();
		
		$tagslist = Tags::get();
		$tagsCount = $tagslist->count();
		
		$citylist = City::get();
		$cityCount = $citylist->count();
		
		$occupationslist = Occupations::get();
		$occupationsCount = $occupationslist->count();
		
		return view('admin.dashboard',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'userCount'=>$userCount,'tagsCount'=>$tagsCount,'cityCount'=>$cityCount,'occupationsCount'=>$occupationsCount]);
	}
	public function profile()
    {
		$main_menu='';
		$sub_menu='';
		$id=Session::get('admin_data')->id;
		$data=Admin::find($id);
		
		return view('admin.profile',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'data'=>$data]);
	}
	public function edit_profile(Request $request)
    {
		$id=Session::get('admin_data')->id;
		
		$input = $request->all();
		
		$rules['name'] = 'required';
		$messages['name.required']='Name is required';
		
		$rules['email'] = 'required|email|unique:admins,email, '. $id . ',id';
		$messages['email.required']='Email is required';
		
		$rules['mobile_no'] = 'required';
		$messages['mobile_no.required']='Mobile No is required';
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$name = $request->name;
			$email = $request->email;
			$mobile_no = $request->mobile_no;
		
			$data=Admin::find($id);
			$data->name=$name;
			$data->email=$email;
			$data->mobile_no=$mobile_no;
			if ($request->hasFile('image')) {
				$row_img=Admin::find($id);
				$image_path = base_path("public/upload/admin/".$row_img->image); 
				if(File::exists($image_path)) {
					File::delete($image_path);
				}
				$image = $request->file('image');
				$file_name =str_replace(" ","-",$image->getClientOriginalName());
				$file_name=$id.$file_name;
				$destinationPath = base_path('public/upload/admin');
				$image->move($destinationPath, $file_name);
				$data->image=$file_name;
			}
			$data->save();
			$data_admin=Admin::find($id);
			Session::put('admin_data', $data_admin);
			session()->save();
			return redirect('admin/profile')->with('success', 'Profile update successfully.');
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}	
	}
	public function change_password()
    {
		$main_menu='';
		$sub_menu='';
		return view('admin.change_password',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu]);			
	}
	public function change_password_update(Request $request)
    {
		$id=Session::get('admin_data')->id;
		$data_admin=Admin::find($id);
				
		$request->validate([
			'opassword' => 'required',
            'npassword' => 'required',
			'cpassword' => 'required|same:npassword',
        ],[
    		'opassword.required' => 'Password is required',
			'npassword.required' => 'New Password is required',
			'cpassword.required' => 'Comfirm Password is required',
			'cpassword.same' => 'New password and Comfirm password not match',
			]);
		 $db_password=$data_admin->password;
		 $opassword = $request->opassword;
		$npassword = $request->npassword;
		if(Hash::check($opassword, $db_password))
		{
			$npassword = Hash::make($npassword);				
			 $admin = Admin::find($id);
			$admin->password = $npassword;
			$admin->save();
			return redirect('admin/change_password')->with('success','Password Update Successfully!');	
		}else{
			return redirect('admin/change_password')->with('danger','Wrong Old Password!');	
		}			
	}
   public function changestatus(Request $request)
   {
   		$data[$request->id_name] = $request->id;
		$data[$request->field_name] =  $request->status;
		$dataId = $request->id;
    	$fieldName = $request->id_name;
    	$table = $request->table;
		
		DB::table($table)->where($fieldName, $dataId)->update($data);
		return response()->json(['success'=>1]);
   }
   public function update_document_status(Request $request)
   {
       $id=$request->id;
       $document_name=$request->document_name;
       $status=$request->status;
       $data=User::find($id);
       if($document_name=='Work permit'){  
           $data->permission_to_work1_status=$status;
       }else if($document_name=='Passport')
       {
           $data->passport_status=$status;
       }else if($document_name=='National ID')
       {
           $data->national_id_status=$status;
       }else if($document_name=='CV')
       {
           $data->cv_status=$status;
       }else if($document_name=='Other relevant document')
       {
           $data->other_relevant_document_status=$status;
       }
       $data->save();
       $json_data['status'] = 1;
        $json_data['message']    = 'Document Status has been updated.';
        echo json_encode($json_data);
        exit;
   }
    public function logout(Request $request)
    {
    	$request->session()->flush();
        return redirect('admin/login');
    }
}
