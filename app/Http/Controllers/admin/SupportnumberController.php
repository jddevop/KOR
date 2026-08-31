<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Support_number;
use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
class SupportnumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$main_menu='support_number';
		$sub_menu='support_number';
		
		$data=Support_number::find(1);
		
		return view('admin.add_support_number',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'data'=>$data]);
	}
	public function store(Request $request)
    {
		$id=1;
		
		$input = $request->all();
		
		$rules['support_number'] = 'required';
		$messages['support_number.required']='Support Number is required';
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$support_number = $request->support_number;
		
			$data=Support_number::find($id);
			$data->support_number=$support_number;
			$data->save();
			
			return redirect('admin/support_number')->with('success', 'Support Number update successfully.');
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}	
	}
}
