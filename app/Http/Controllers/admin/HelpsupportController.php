<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Help_support;
use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
class HelpsupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main_menu='help_support';
		$sub_menu='help_support';
        $view_data=Help_support::orderBy('id', 'desc')->get();
        return view('admin.view_help_support',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'view_data' => $view_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $main_menu='help_support';
		$sub_menu='help_support'; 
	    $mode='Add';
		
	
				
		return view('admin.add_help_support',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'mode'=>$mode]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 public function store(Request $request)
    {
        $input = $request->all();
		
		$rules['name'] = 'required';
		$messages['name.required']='Name is required';
		
		$rules['description'] = 'required';
		$messages['description.required']='Description is required';
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$name = $request->name;
			$description = $request->description;

			$ins=new Help_support;
			$ins->name=$name;
			$ins->description=$description;
			if($ins->save())
			{
				return redirect('admin/help_support')->with('success', 'Help & Support added successfully.');
			}else{
				return redirect('admin/help_support')->with('error', 'Help & Support added fail.');
			}
		}else{
			return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $main_menu='help_support';
		$sub_menu='help_support'; 
	    $mode='Edit';
	   
	   $data=Help_support::find($id);
	   
	   
	   return view('admin.add_help_support',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'mode'=>$mode,'data'=>$data]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->isMethod('PATCH')){
			$input = $request->all();
		
		    $rules['name'] = 'required';
		    $messages['name.required']='Name is required';
		
    		$rules['description'] = 'required';
    		$messages['description.required']='Description is required';

		
			$validator = Validator::make($input, $rules,$messages);
			if ($validator->passes()) {	
			    $name = $request->name;
				$description = $request->description;
				
				$data=Help_support::find($id);
				$data->name=$name;
				$data->description=$description;
				$data->save();
				return redirect('admin/help_support')->with('success', 'Help & Support updated successfully.');
			}else{
				return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
			}
		}else{
			return back()->with('error', 'Invalid request');
		  }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Help_support::find($id); 
        if($data->delete()){          
            $result = array('status' => true, 'message' => 'Success!', 'result' => '');
        }else{
          $result = array('status' => false, 'message' => 'Fail!', 'result' => '');  
        }
        echo json_encode($result);
        exit;
    }
}
