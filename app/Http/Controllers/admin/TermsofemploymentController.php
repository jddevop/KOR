<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Terms_of_employment;
use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
class TermsofemploymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$main_menu='terms_of_employment';
		$sub_menu='terms_of_employment';
		
		$data=Terms_of_employment::find(1);
		
		return view('admin.add_terms_of_employment',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'data'=>$data]);
	}
	public function store(Request $request)
    {
		$id=1;
		
		$input = $request->all();
		$rules['status'] = 'required';
		$messages['status.required']='Status is required';
		if ($request->hasFile('doc')) { }else{
			$rules['doc'] = 'required';
			$messages['doc.required']='Doc is required';	
		}
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			
		
			$data=Terms_of_employment::find($id);
		
			$data->status=1;
			if ($request->hasFile('doc')) {
				$row_img=Terms_of_employment::find($id);
				$image_path = base_path("public/upload/terms_of_employment/".$row_img->doc); 
				if(File::exists($image_path)) {
					File::delete($image_path);
				}
			
				$image = $request->file('doc');
				$file_name =str_replace(" ","-",$image->getClientOriginalName());
				$file_name=$id.$file_name;
				$destinationPath = base_path('public/upload/terms_of_employment');
				$image->move($destinationPath, $file_name);
				$data->doc=$file_name;
			}
			$data->save();
			
			return redirect('admin/terms_of_employment')->with('success', 'Terms of Employment update successfully.');
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}	
	}
}
