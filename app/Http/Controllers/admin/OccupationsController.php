<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Occupations;
use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
class OccupationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main_menu='settings';
		$sub_menu='occupations';
        $view_data=Occupations::orderBy('id', 'desc')->get();
        return view('admin.view_occupations',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'view_data' => $view_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $main_menu='settings';
		$sub_menu='occupations'; 
	    $mode='Add';
		
	
				
		return view('admin.add_occupations',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'mode'=>$mode]); 
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
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$name = $request->name;

			$ins=new Occupations;
			$ins->name=$name;
			if($ins->save())
			{
				return redirect('admin/occupations')->with('success', 'Occupations added successfully.');
			}else{
				return redirect('admin/occupations')->with('error', 'Occupations added fail.');
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
        $main_menu='settings';
		$sub_menu='occupations'; 
	    $mode='Edit';
	   
	   $data=Occupations::find($id);
	   
	   
	   return view('admin.add_occupations',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'mode'=>$mode,'data'=>$data]);  
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

		
			$validator = Validator::make($input, $rules,$messages);
			if ($validator->passes()) {	
				$name = $request->name;
				
				$data=Occupations::find($id);
				$data->name=$name;
				$data->save();
				return redirect('admin/occupations')->with('success', 'Occupations updated successfully.');
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
        $data = Occupations::find($id); 
        if($data->delete()){          
            $result = array('status' => true, 'message' => 'Success!', 'result' => '');
        }else{
          $result = array('status' => false, 'message' => 'Fail!', 'result' => '');  
        }
        echo json_encode($result);
        exit;
    }
}
