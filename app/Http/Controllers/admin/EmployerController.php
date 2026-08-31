<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Employer;
use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$main_menu='employer';
		$sub_menu='employer';
		
		$data=Employer::find(1);
		
		return view('admin.add_employer',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'data'=>$data]);
	}
	public function store(Request $request)
    {
		$id=1;
		
		$input = $request->all();
		
		$rules['employer_name'] = 'required';
		$messages['employer_name.required']='Employer Name is required';
		
		$rules['employer_number'] = 'required';
		$messages['employer_number.required']='Employer Number is required';
		
		$rules['email'] = 'required';
		$messages['email.required']='Email is required';
		
		$rules['contact_number'] = 'required';
		$messages['contact_number.required']='Contact Number is required';
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$employer_name = $request->employer_name;
			$employer_number = $request->employer_number;
			$email = $request->email;
		    $contact_number = $request->contact_number;
		
			$data=Employer::find($id);
			$data->employer_name=$employer_name;
			$data->employer_number=$employer_number;
			$data->email=$email;
			$data->contact_number=$contact_number;
			if ($request->hasFile('image')) {
				$row_img=Employer::find($id);
				$image_path = base_path("public/upload/employer/".$row_img->image); 
				if(File::exists($image_path)) {
					File::delete($image_path);
				}
			
				$image = $request->file('image');
				$file_name =str_replace(" ","-",$image->getClientOriginalName());
				$file_name=$id.$file_name;
				$destinationPath = base_path('public/upload/employer');
				$image->move($destinationPath, $file_name);
				$data->image=$file_name;
			}
			$data->save();
			
			return redirect('admin/employer')->with('success', 'Employer update successfully.');
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}	
	}
}
