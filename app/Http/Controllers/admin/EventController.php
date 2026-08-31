<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Event;
use App\Models\Tags;
use App\Models\English_level;
use App\Models\Users_event_status;
use App\Models\Occupations;
use App\Models\City;
use App\Models\Event_shift;
use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main_menu='event';
		$sub_menu='event';
        $view_data=Event::where('end_date','>=',date('Y-m-d'))->orderBy('id', 'desc')->get();
        return view('admin.view_event',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'view_data' => $view_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $main_menu='event';
		$sub_menu='event'; 
	    $mode='Add';
		
		return view('admin.add_event',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'mode'=>$mode]); 
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
		
		if ($request->hasFile('image')) { }else{
			$rules['image'] = 'required';
			$messages['image.required']='Image is required';	
		}
		
		/*if ($request->hasFile('company_logo')) { }else{
			$rules['company_logo'] = 'required';
			$messages['company_logo.required']='Company Logo is required';	
		}*/
		
		$rules['start_date'] = 'required';
		$messages['start_date.required']='Start Date is required';
		
		$rules['end_date'] = 'required';
		$messages['end_date.required']='End Date is required';
		
		/*$rules['shift_start_time'] = 'required';
		$messages['shift_start_time.required']='Shift Start Time is required';
		
		$rules['shift_end_time'] = 'required';
		$messages['shift_end_time.required']='Shift End Time is required';*/
		if($request->address=='')
		{
		    $rules['address'] = 'required';
		    $messages['address.required']='Address is required';
		}else{
		    if($request->lat=='' || $request->long==''){
		        $rules['address1'] = 'required';
		        $messages['address1.required']='Address is required';
		    }
		}
		/*$rules['short_text_address'] = 'required';
		$messages['short_text_address.required']='Short Text Address is required';*/
		
		if($request->meeting_point_address=='')
		{
		    $rules['meeting_point_address'] = 'required';
		    $messages['meeting_point_address.required']='Meeting Point Address is required';
		}else{
		    if($request->meeting_point_lat=='' || $request->meeting_point_long==''){
		        $rules['meeting_point_address1'] = 'required';
		        $messages['meeting_point_address1.required']='Meeting Point Address is required';
		    }
		}
		$rules['short_text_meeting_point_address'] = 'required';
		$messages['short_text_meeting_point_address.required']='Short Text Meeting Point Address is required';
		    
		$rules['role'] = 'required';
		$messages['role.required']='Role is required';
		
		$rules['whatsapp_group_link'] = 'required';
		$messages['whatsapp_group_link.required']='Whatsapp Group Link is required';
		
		$rules['total_staff_required'] = 'required';
		$messages['total_staff_required.required']='Total Staff Required is required';
		
		$rules['payment_rate'] = 'required';
		$messages['payment_rate.required']='Payment Rate is required';
		
		$rules['short_description'] = 'required';
		$messages['short_description.required']='Short Description is required';
		
		$rules['description'] = 'required';
		$messages['description.required']='Description is required';
		
		$rules['what_you_will_be_doing'] = 'required';
		$messages['what_you_will_be_doing.required']='what you will be doing is required';
		
		$rules['general_information'] = 'required';
		$messages['general_information.required']='General Information is required';
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
			$name = $request->name;
			$start_date = $request->start_date;
			$end_date = $request->end_date;
			//$shift_start_time = $request->shift_start_time;
			//$shift_end_time = $request->shift_end_time;
			$address = $request->address;
			$lat = $request->lat;
			$long = $request->long;
			//$short_text_address = $request->short_text_address;
			
			
			$meeting_point_address = $request->meeting_point_address;
			$meeting_point_lat = $request->meeting_point_lat;
			$meeting_point_long = $request->meeting_point_long;
			$short_text_meeting_point_address = $request->short_text_meeting_point_address;
			
			$role = $request->role;
			$whatsapp_group_link = $request->whatsapp_group_link;
			$total_staff_required = $request->total_staff_required;
			$payment_rate = $request->payment_rate;
			$short_description = $request->short_description;
			$description = $request->description;
			$what_you_will_be_doing = $request->what_you_will_be_doing;
			$general_information = $request->general_information;
			$transport = $request->transport;

			$ins=new Event;
			$ins->name=$name;
			$ins->start_date=date("Y-m-d",strtotime($start_date));
			$ins->end_date=date("Y-m-d",strtotime($end_date));
			//$ins->shift_start_time=date("H:i:s",strtotime($shift_start_time));
			//$ins->shift_end_time=date("H:i:s",strtotime($shift_end_time));
			$ins->address=$address;
			$ins->lat=$lat;
			$ins->long=$long;
			//$ins->short_text_address=$short_text_address;
			$ins->meeting_point_address=$meeting_point_address;
			$ins->meeting_point_lat=$meeting_point_lat;
			$ins->meeting_point_long=$meeting_point_long;
			$ins->short_text_meeting_point_address=$short_text_meeting_point_address;
			$ins->role=$role;
			$ins->whatsapp_group_link=$whatsapp_group_link;
			$ins->total_staff_required=$total_staff_required;
			$ins->transport=$transport;
			$ins->payment_rate=$payment_rate;
			$ins->short_description=$short_description;
			$ins->description=$description;
			$ins->what_you_will_be_doing=$what_you_will_be_doing;
			$ins->general_information=$general_information;
			if ($request->hasFile('image')) {
				$image = $request->file('image');
				$file_name =str_replace(" ","-",$image->getClientOriginalName());
				$file_name=$file_name;
				$destinationPath = base_path('public/upload/event');
				$image->move($destinationPath, $file_name);
				$ins->image=$file_name;
			}
			/*if ($request->hasFile('company_logo')) {
				$image = $request->file('company_logo');
				$file_name =str_replace(" ","-",$image->getClientOriginalName());
				$file_name=$file_name;
				$destinationPath = base_path('public/upload/event');
				$image->move($destinationPath, $file_name);
				$ins->company_logo=$file_name;
			}*/
			if($ins->save())
			{
				return redirect('admin/event')->with('success', 'Event added successfully.');
			}else{
				return redirect('admin/event')->with('error', 'Event added fail.');
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
        $main_menu='event';
		$sub_menu='event'; 
	    $mode='Edit';
	   
	    $data=Event::find($id);
	   
	   return view('admin.add_event',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'mode'=>$mode,'data'=>$data]);  
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
    		
    		$rules['start_date'] = 'required';
    		$messages['start_date.required']='Start Date is required';
    		
    		$rules['end_date'] = 'required';
    		$messages['end_date.required']='End Date is required';
    		
    		/*$rules['shift_start_time'] = 'required';
    		$messages['shift_start_time.required']='Shift Start Time is required';*/
    		
    		/*$rules['shift_end_time'] = 'required';
    		$messages['shift_end_time.required']='Shift End Time is required';*/
    		
    		if($request->address=='')
    		{
    		    $rules['address'] = 'required';
    		    $messages['address.required']='Address is required';
    		}else{
    		    if($request->lat=='' || $request->long==''){
    		        $rules['address1'] = 'required';
    		        $messages['address1.required']='Address is required';
    		    }
    		}
    		/*$rules['short_text_address'] = 'required';
    		$messages['short_text_address.required']='Short Text Address is required';*/
    		
    		if($request->meeting_point_address=='')
    		{
    		    $rules['meeting_point_address'] = 'required';
    		    $messages['meeting_point_address.required']='Meeting Point Address is required';
    		}else{
    		    if($request->meeting_point_lat=='' || $request->meeting_point_long==''){
    		        $rules['meeting_point_address1'] = 'required';
    		        $messages['meeting_point_address1.required']='Meeting Point Address is required';
    		    }
    		}
    		$rules['short_text_meeting_point_address'] = 'required';
    		$messages['short_text_meeting_point_address.required']='Short Text Meeting Point Address is required';
    		
    		$rules['role'] = 'required';
		    $messages['role.required']='Role is required';
		    
		    $rules['whatsapp_group_link'] = 'required';
		    $messages['whatsapp_group_link.required']='Whatsapp Group Link is required';
		    
		    $rules['total_staff_required'] = 'required';
		    $messages['total_staff_required.required']='Total Staff Required is required';
    		
    		$rules['payment_rate'] = 'required';
    		$messages['payment_rate.required']='Payment Rate is required';
    		
    		$rules['short_description'] = 'required';
		    $messages['short_description.required']='Short Description is required';
    		
    		$rules['description'] = 'required';
    		$messages['description.required']='Description is required';
    		
    		$rules['what_you_will_be_doing'] = 'required';
    		$messages['what_you_will_be_doing.required']='what you will be doing is required';
    		
    		$rules['general_information'] = 'required';
    		$messages['general_information.required']='General Information is required';

			$validator = Validator::make($input, $rules,$messages);
			if ($validator->passes()) {	
			    $name = $request->name;
    			$start_date = $request->start_date;
    			$end_date = $request->end_date;
    			//$shift_start_time = $request->shift_start_time;
    			//$shift_end_time = $request->shift_end_time;
    			$address = $request->address;
    			$lat = $request->lat;
    			$long = $request->long;
    			//$short_text_address = $request->short_text_address;
			
    			$meeting_point_address = $request->meeting_point_address;
    			$meeting_point_lat = $request->meeting_point_lat;
    			$meeting_point_long = $request->meeting_point_long;
    			$short_text_meeting_point_address = $request->short_text_meeting_point_address;
    			$role = $request->role;
    			$whatsapp_group_link = $request->whatsapp_group_link;
    			$total_staff_required = $request->total_staff_required;
    			$payment_rate = $request->payment_rate;
    			$short_description = $request->short_description;
    			$description = $request->description;
    			$what_you_will_be_doing = $request->what_you_will_be_doing;
    			$general_information = $request->general_information;
    			$transport = $request->transport;
				
				$data=Event::find($id);
				$data->name=$name;
    			$data->start_date=date("Y-m-d",strtotime($start_date));
    			$data->end_date=date("Y-m-d",strtotime($end_date));
    			//$data->shift_start_time=date("H:i:s",strtotime($shift_start_time));
    			//$data->shift_end_time=date("H:i:s",strtotime($shift_end_time));
    			$data->address=$address;
    			$data->lat=$lat;
    			$data->long=$long;
    			//$data->short_text_address=$short_text_address;
    			$data->meeting_point_address=$meeting_point_address;
    			$data->meeting_point_lat=$meeting_point_lat;
    			$data->meeting_point_long=$meeting_point_long;
    			$data->short_text_meeting_point_address=$short_text_meeting_point_address;
    			$data->role=$role;
    			$data->whatsapp_group_link=$whatsapp_group_link;
    			$data->total_staff_required=$total_staff_required;
    			$data->transport=$transport;
    			$data->payment_rate=$payment_rate;
    			$data->short_description=$short_description;
    			$data->description=$description;
    			$data->what_you_will_be_doing=$what_you_will_be_doing;
    			$data->general_information=$general_information;
    			if ($request->hasFile('image')) {
					$row_img=Event::find($id);
					$image_path = base_path("public/upload/event/".$row_img->image); 
					if(File::exists($image_path)) {
						File::delete($image_path);
					}
				
					$image = $request->file('image');
					$file_name =str_replace(" ","-",$image->getClientOriginalName());
					$file_name=$id.$file_name;
					$destinationPath = base_path('public/upload/event');
					$image->move($destinationPath, $file_name);
					$data->image=$file_name;
				}
				/*if ($request->hasFile('company_logo')) {
					$row_img=Event::find($id);
					$image_path = base_path("public/upload/event/".$row_img->company_logo); 
					if(File::exists($image_path)) {
						File::delete($image_path);
					}
				
					$image = $request->file('company_logo');
					$file_name =str_replace(" ","-",$image->getClientOriginalName());
					$file_name=$id.$file_name;
					$destinationPath = base_path('public/upload/event');
					$image->move($destinationPath, $file_name);
					$data->company_logo=$file_name;
				}*/
				$data->save();
				return redirect('admin/event')->with('success', 'Event updated successfully.');
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
        $data = Event::find($id); 
       $image_path = base_path("public/upload/event/".$data->image);
		$image_path1 = base_path("public/upload/event/".$data->company_logo); 
					
        if($data->delete()){ 
            if(File::exists($image_path)) {
				File::delete($image_path);
			}
			if(File::exists($image_path1)) {
				File::delete($image_path1);
			}
            $result = array('status' => true, 'message' => 'Success!', 'result' => '');
        }else{
          $result = array('status' => false, 'message' => 'Fail!', 'result' => '');  
        }
        echo json_encode($result);
        exit;
    }
    public function event_users(Request $request)
    {
        if(!empty($request->id))
        {
            $id=$request->id;
            $main_menu='event';
    		$sub_menu='event users';
    		
            $assignedUserIds = DB::table('users_event_status')
                                ->where('event_id', $id)
                                ->pluck('user_id')
                                ->toArray();
        
            $all_users = DB::table('users')
                            ->whereNotIn('id', $assignedUserIds)
                            ->get();
    		
    		
            $view_data = DB::table('users_event_status')
            ->join('users', 'users_event_status.user_id', '=', 'users.id')
            ->join('event', 'users_event_status.event_id', '=', 'event.Id')
            ->where('users_event_status.event_id', $id)
            ->select('users_event_status.*', 'users.first_name', 'users.last_name', 'event.name as event_name')
            ->get();
            return view('admin.view_event_users',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'view_data' => $view_data,'all_users'=>$all_users,'event_id'=>$id]);
        }else{
            return redirect('admin/event')->with('success', 'Something went wrong.');
        }
    }
    public function update_event_users_status(Request $request)
    {
       $input = $request->all();
		$rules['user_id'] = 'required';
		$messages['user_id.required']='User is required'; 
		
		$rules['event_id'] = 'required';
		$messages['event_id.required']='Event is required';
		
		$validator = Validator::make($input, $rules,$messages);
		if ($validator->passes()) {
		    $user_id=$request->user_id;
		    $event_id=$request->event_id;
    		$exists = DB::table('users_event_status')
                    ->where('user_id', $request->user_id)
                    ->where('event_id', $request->event_id)
                    ->exists();
                if (!$exists) {
                    $ins=new Users_event_status;
    			    $ins->user_id=$user_id;
    				$ins->event_id=$event_id;
    				$ins->event_status=1;
    				$ins->save();
                    
                    $json_data['status']=1;
            		$json_data['message']	= 'User invited successfully!';
            		echo json_encode($json_data);
            		exit;
                }
            $json_data['status']=0;
    		$json_data['message']	= 'User already invited to this event.';
    		echo json_encode($json_data);
    		exit;
		}else{
			$json_data['status']=0;
    		$json_data['message']	= 'Something went wrong.';
    		echo json_encode($json_data);
    		exit;
		}
    }
    public function search_event_users(Request $request)
    {
        if(!empty($request->id))
        {
            $event_id=$request->id;
            $main_menu='event';
    		$sub_menu='search_event_users';
                $tags_data=Tags::where('status',1)->get();
             
              $english_level_data = English_level::where('status', 1)->get();
              
              $occupations_data = Occupations::where('status', 1)->get();
              
              $city_data = City::where('status', 1)->get();
             
            return view('admin.view_search_event_users',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'tags_data' => $tags_data,'english_level_data'=>$english_level_data,'occupations_data'=>$occupations_data,'city_data'=>$city_data,'event_id'=>$event_id]);
    
        }else{
            return redirect('admin/event')->with('success', 'Something went wrong.');
        }        
    }
    public function event_delete(Request $request)
    {
        $ids = explode(',', $request->id);
        $events = Event::whereIn('id', $ids)->get();
        if ($events->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No records found!'
            ]);
        }
        foreach ($events as $event) {
            // File paths
            $image_path = public_path("upload/event/" . $event->image);
            $logo_path  = public_path("upload/event/" . $event->company_logo);
    
            // Delete files first
            if ($event->image && File::exists($image_path)) {
                File::delete($image_path);
            }
            if ($event->company_logo && File::exists($logo_path)) {
                File::delete($logo_path);
            }
            // Delete record
            $event->delete();
        }
        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully!'
        ]);
    }
   public function export_event(Request $request)
    {
        $fileName = 'events.csv';
    
        $events = Event::where('end_date', '>=', date('Y-m-d'))
            ->orderBy('id', 'desc')
            ->get();
    
        $headers = [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate",
            "Expires"             => "0"
        ];
    
        $columns = [
            'Name',
            'Start Date',
            'End Date',
            'Address',
            'Short Text Address',
            'Meeting Point Address',
            'Short Text Meeting Point Address',
            'Role',
            'Total Staff Required',
            'Payment Rate',
            'Description',
            'Short Description',
            'What You will be doing',
            'General Information',
            'Transport'
        ];
    
        $callback = function () use ($events, $columns) {
    
            $file = fopen('php://output', 'w');
    
            // UTF-8 BOM (fix Excel issue)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
    
            fputcsv($file, $columns);
    
            foreach ($events as $event) {
                $transport='Not Provided';
                if($event->transport==0)
                {
                    $transport='Not Provided';
                }else{
                    $transport='Provided';
                }
                fputcsv($file, [
                    $event->name,
                    $event->start_date,
                    $event->end_date,
                    $event->address,
                    $event->short_text_address,
                    $event->meeting_point_address,
                    $event->short_text_meeting_point_address,
                    $event->role,
                    $event->total_staff_required,
                    $event->payment_rate,
                    strip_tags($event->description),
                    strip_tags($event->short_description),
                    strip_tags($event->what_you_will_be_doing),
                    strip_tags($event->general_information),
                    $transport
                ]);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=events.csv",
        ]);
    }
    public function event_details(Request $request)
    {
        $event_id=$request->id;
        $data_eve = Event::find($event_id);
        if($data_eve)
        {
            $main_menu='event';
    		$sub_menu='event';
            
            $view_shift=Event_shift::where('event_id',$event_id)->orderBy('id', 'desc')->get();
            
            $inviteuserlist = Users_event_status::where('event_id',$event_id)->where('event_status',1)->get();
    		$inviteuserCount = $inviteuserlist->count();
    		
    		$applayuserlist = Users_event_status::where('event_id',$event_id)->where('event_status',3)->get();
    		$applayuserCount = $applayuserlist->count();
    		
    		$rejectuserlist = Users_event_status::where('event_id',$event_id)->where('event_status',4)->get();
    		$rejectuserCount = $rejectuserlist->count();
    		
    		$confirmuserlist = Users_event_status::where('event_id',$event_id)->where('event_status',5)->get();
    		$confirmuserCount = $confirmuserlist->count();
    		
    		$ongoinguserlist = Users_event_status::where('event_id',$event_id)->where('event_status',6)->get();
    		$ongoinguserCount = $ongoinguserlist->count();
            
            $applied_data = Users_event_status::where('event_id',$event_id)->where('event_status',3)->get();
            
            $accepted_data = Users_event_status::where('event_id',$event_id)->whereIn('event_status', [5, 6, 7])->get();
            
            $rejected_data = Users_event_status::where('event_id',$event_id)->where('event_status',4)->get();
            
            $event_name=$data_eve['name'];
            return view('admin.event_details',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'event_id'=>$event_id,'view_shift'=>$view_shift,'inviteuserCount'=>$inviteuserCount,'applayuserCount'=>$applayuserCount,'rejectuserCount'=>$rejectuserCount,'confirmuserCount'=>$confirmuserCount,'ongoinguserCount'=>$ongoinguserCount,'applied_data'=>$applied_data,'accepted_data'=>$accepted_data,'rejected_data'=>$rejected_data,'event_name'=>$event_name]);
        }else{
            return redirect('admin/event');
        }
    }

    public function get_search_event_users(Request $request)
    {
        $event_id = $request->event_id;
    
        $query = User::select(
                'users.*',
                DB::raw('IF(users_event_status.event_id IS NULL, 0, users_event_status.event_status) as current_event_status')
            )
            ->leftJoin('users_event_status', function($join) use ($event_id) {
                $join->on('users.id', '=', 'users_event_status.user_id')
                     ->where('users_event_status.event_id', $event_id);
            })
            ->where('users.status',1)
            ->where('users.soft_delete',0)
            ->orderByRaw("CONCAT(IFNULL(users.first_name,''), ' ', IFNULL(users.last_name,'')) ASC");
    
        // Condition (IMPORTANT)
        $query->where(function($q) use ($event_id){
            $q->whereNull('users_event_status.event_id') // no record → allow
            ->orWhere('users_event_status.event_status', 1)
            ->orWhere('users_event_status.event_status', 3);
        });
        // Tags
        if(!empty($request->tags_id)){
            $query->where(function($q) use ($request){
                foreach($request->tags_id as $tag){
                    $q->orWhereRaw("FIND_IN_SET(?, users.tags_id)", [$tag]);
                }
            });
        }
    
        // English Level
        if(!empty($request->english_level_id)){
            $query->where('users.english_level_id', $request->english_level_id);
        }
    
        // Nationality
        if(!empty($request->nationality)){
            $query->where('users.nationality', $request->nationality);
        }
    
        // Gender
        if(!empty($request->gender)){
            $query->where('users.gender', $request->gender);
        }
    
        // Experience
        if(!empty($request->area_experience_occupations_id)){
            $query->whereRaw(
                "FIND_IN_SET(?, users.area_experience_occupations_id)", 
                [$request->area_experience_occupations_id]
            );
        }
    
        // City
        if(!empty($request->city_id)){
            $query->where('users.city_id', $request->city_id);
        }
        
        //  SEARCH (First + Last + Email)
        if(!empty($request->search_val)){
            $search = trim($request->search_val);
        
            $query->where(function($q) use ($search){
                $q->where('users.first_name', 'LIKE', "{$search}%")
                  ->orWhere('users.last_name', 'LIKE', "{$search}%")
                  ->orWhere('users.email', 'LIKE', "{$search}%")
                  ->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ["{$search}%"]);
            });
        }
        
        $view_data = $query->get();
    
        $html_data = view('admin.get_search_event_users', compact('view_data'))->render();
    
        return response()->json([
            'status' => 1,
            'html_data' => $html_data,
            'message' => ''
        ]);
    }
    public function invite_user(Request $request)
    {
        $ids = explode(',', $request->id);
        $events = User::whereIn('id', $ids)->get();
        if ($events->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No records found!'
            ]);
        }
        
        foreach($ids as $key=>$val){
            $exists = DB::table('users_event_status')
                        ->where('user_id', $val)
                        ->where('event_id', $request->event_id)
                        ->exists();
        
                    if (!$exists) {
                        $ins=new Users_event_status;
        			    $ins->user_id=$val;
        				$ins->event_id=$request->event_id;
        				$ins->event_status=1;
        				$ins->save();
        				$msg='You have been invited to an event. Please accept or decline.';
        				
        				send_notification(0,$val,$request->event_id,6,$msg,0,0);
        				$url=route('dashboard');
        				send_noti_fcm('Event invitation',$msg,$val,$url);
                    }
        }
        $json_data['status']=1;
		$json_data['message']	= 'User invited successfully!';
		echo json_encode($json_data);
		exit;
    }
    public function invite_user_single(Request $request)
    {
        $ids = $request->id;
        
        
            $exists = DB::table('users_event_status')
                        ->where('user_id', $ids)
                        ->where('event_id', $request->event_id)
                        ->exists();
        
                    if (!$exists) {
                        $ins=new Users_event_status;
        			    $ins->user_id=$ids;
        				$ins->event_id=$request->event_id;
        				$ins->event_status=1;
        				$ins->save();
        				$msg='You have been invited to an event. Please accept or decline.';
        				
        				send_notification(0,$val,$request->event_id,6,$msg,0,0);
        				$url=route('dashboard');
        				send_noti_fcm('Event invitation',$msg,$val,$url);
                    }
        
        $json_data['status']=1;
		$json_data['message']	= 'User invited successfully!';
		echo json_encode($json_data);
		exit;
    }
    public function get_search_event(Request $request)
    {
        $query=User::orderBy('id', 'desc');
        $date=date('Y-m-d');
        $query=Event::orderBy('id', 'desc');
        
        if(!empty($request->status)){
            if($request->status=='upcoming')
            {
                $query->where('start_date','>=',$date);
            }else if($request->status=='ongoing')
            {
                $query->where('start_date', '<=', $date)
                  ->where('end_date', '>=', $date);
            }
        }else{
            $query->where('end_date','>=', $date);
        }
         if (!empty($request->from_date) && !empty($request->to_date)) {
            $query->whereDate('start_date', '>=', $request->from_date)
                  ->whereDate('end_date', '<=', $request->to_date);
        }
        $view_data = $query->get();
        
        $html_data = view('admin.get_search_event', compact('view_data'))->render();
    
        return response()->json([
            'status' => 1,
            'html_data' => $html_data,
            'message' => ''
        ]);
    }
    public function add_shift(Request $request)
    {
        $input = $request->all();
    
        $rules['event_id'] = 'required';
		$messages['event_id.required']='Event Id is required';
    
		$rules['name'] = 'required';
		$messages['name.required']='Name is required';

		$rules['start_time'] = 'required';
		$messages['start_time.required']='Start Time is required';

		$rules['end_time'] = 'required';
		$messages['end_time.required']='End Time is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $event_id=$request->event_id;
		    $name=$request->name;
		    $start_time=$request->start_time;
		    $end_time=$request->end_time;
		   
		    
		    $ins=new Event_shift;
			$ins->event_id=$event_id;
			$ins->name=$name;
			$ins->start_time=date("H:i:s",strtotime($start_time));
			$ins->end_time=date("H:i:s",strtotime($end_time));
			if($ins->save())
			{
                $json_data['status'] = 1;
                $json_data['message']    = 'Shift added successfully.';
                echo json_encode($json_data);
                exit;
			}else{
			    $json_data['status'] = 0;
				$json_data['message']    = 'Shift added fail.';
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
    public function edit_shift(Request $request)
    {
        $id=$request->id;
        $event_shift = Event_shift::find($id); 
        $data=array();
        if($event_shift) {
            $data = [
                    'id'   => $event_shift->id,
                    'name'   => $event_shift->name,   
                    'start_time' => $event_shift->start_time,
                    'end_time'           => $event_shift->end_time
                ];
        }
        $json_data['status'] = 1;
		$json_data['message']    ='';
		$json_data['data']    =$data;
		echo json_encode($json_data);
		exit;
    }
    public function update_shift(Request $request)
    {
        $input = $request->all();
    
        $rules['edit_id'] = 'required';
		$messages['edit_id.required']='Id is required';
    
		$rules['name'] = 'required';
		$messages['name.required']='Name is required';

		$rules['start_time'] = 'required';
		$messages['start_time.required']='Start Time is required';

		$rules['end_time'] = 'required';
		$messages['end_time.required']='End Time is required';
		
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $edit_id=$request->edit_id;
		    $name=$request->name;
		    $start_time=$request->start_time;
		    $end_time=$request->end_time;
		   
		    
		    $data = Event_shift::find($edit_id);
			$data->name=$name;
			$data->start_time=date("H:i:s",strtotime($start_time));
			$data->end_time=date("H:i:s",strtotime($end_time));
			if($data->save())
			{
			    if($data->users_event_status_id!='')
			    {
			        $userIds = explode(",", $data->users_event_status_id);
			        $userIds = array_unique($userIds); // avoid duplicate
                    foreach ($userIds as $userId) {
                        $data_u = Users_event_status::find($userId);
                        if(!empty($data_u)){
                            $msg = "Your shift has been assigned or updated. Check now for new information.";
                            send_notification(0,$data_u->user_id,$data->event_id,8,$msg,0,0);
                            $url=route('dashboard');
                            send_noti_fcm('Shift updated', $msg, $data_u->user_id,$url);
                        }
                    }
			    }
                $json_data['status'] = 1;
                $json_data['message']    = 'Shift updated successfully.';
                echo json_encode($json_data);
                exit;
			}else{
			    $json_data['status'] = 0;
				$json_data['message']    = 'Shift updated fail.';
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
    public function get_staff(Request $request)
    {
        $id=$request->id;
        $event_id=$request->event_id;
         $search = $request->search_val;
        $event_shift = Event_shift::find($id); 
        if(!empty($event_shift))
        {
            /*$staff_data = Users_event_status::where('event_id', $event_id)->whereIn('event_status', [5, 6])->get();*/
            
            
            /*$staff_data = Users_event_status::where('event_id', $event_id)
            ->whereIn('event_status', [5, 6])
            ->whereHas('user', function($q) use ($search){
                if(!empty($search)){
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["{$search}%"])
                      ->orWhere('email', 'LIKE', "{$search}%");
                }
            })
            ->orderByRaw("CONCAT(user.first_name, ' ', user.last_name) ASC")
            ->with('user') // relation load
            ->get();*/


            $staff_data = Users_event_status::select('users_event_status.*')
            ->join('users', 'users.id', '=', 'users_event_status.user_id')
            ->where('users_event_status.event_id', $event_id)
            ->whereIn('users_event_status.event_status', [5, 6])
            ->when(!empty($search), function($q) use ($search) {
                $q->where(function($sub) use ($search) {
                    $sub->whereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ["{$search}%"])
                        ->orWhere('users.email', 'LIKE', "{$search}%");
                });
            })
            ->orderByRaw("CONCAT(users.first_name, ' ', users.last_name) ASC") //  ascending order
            ->with('user') // relation pan load thase
            ->get();

            $arr_user=array();
            if($event_shift['users_event_status_id']!='')
            {
                $arr_user=explode(",",$event_shift['users_event_status_id']);
            }
            $arr=array();
            $i=0;
            foreach($staff_data as $key=>$val){
                if($val->user)
                {
                    $arr[$i]['id']=$val['id'];
                    $arr[$i]['employee_id']=$val->user->employee_id;
                    $arr[$i]['first_name']=$val->user->first_name;
                    $arr[$i]['last_name']=$val->user->last_name;
                    $arr[$i]['email']=$val->user->email;
                    $arr[$i]['country_code']=$val->user->country_code;
                    $arr[$i]['phone']=$val->user->phone;
                    $arr[$i]['tags_id']=$val->user->tags_id;
                    $cheked_status=0;
                    if(in_array($val['id'], $arr_user))
                    {
                        $cheked_status=1;
                    }
                    $arr[$i]['cheked_status']=$cheked_status;
                    $i++;
                }
            }
            
            usort($arr, function ($a, $b) {
    return $a['cheked_status'] <=> $b['cheked_status'];
});
            $html_data = view('admin.get_staff', ['staff_data'=>$arr,'arr_user'=>$arr_user])->render();
            $json_data['status'] = 1;
    		$json_data['message']    ='';
    		$json_data['html_data']    =$html_data;
    		echo json_encode($json_data);
		    exit;
        }
    }
    public function assign_staff(Request $request)
    {
        if (!empty($request->assign_staff)) {
    
            $event_shift_id = $request->event_shift_id;
            $assign_staff = implode(",", $request->assign_staff); // fixed
            $staff_data_exists = Event_shift::where('id', $event_shift_id)->first();

            $arr_exist = [];
    
            if (!empty($staff_data_exists) && !empty($staff_data_exists->users_event_status_id)) {
                $arr_exist = explode(",", $staff_data_exists->users_event_status_id);
            }
    
            $data = Event_shift::find($event_shift_id);
    
            if ($data) {
                $data->users_event_status_id = $assign_staff;
    
                if ($data->save()) {
                    
                    // event name
                    $event_name = '';
                    if ($data->event) {
                        $event_name = $data->event->name;
                    }
                    $msg = "You have been assigned to ".$data->name." on ".$event_name.": ".$data->start_time." – ".$data->end_time.".";
                    foreach ($request->assign_staff as $userId) {
                        if (!in_array($userId, $arr_exist)) {
                        $data_u = Users_event_status::find($userId);
                        if(!empty($data_u)){
                            send_notification(0,$data_u->user_id,$data->event_id,7,$msg,0,0);
                            $url=route('dashboard');
                            send_noti_fcm('Event confirmation', $msg, $data_u->user_id,$url);
                        }
                        }
                    }
                    
                    
                    return response()->json([
                        'status' => 1,
                        'message' => 'Shift assign successfully.'
                    ]);
                }
            }
    
            return response()->json([
                'status' => 0,
                'message' => 'Shift assign fail.'
            ]);
        }
    
        return response()->json([
            'status' => 0,
            'message' => 'No staff selected.'
        ]);
    }
   
    public function accept_staff(Request $request)
    {
        if (empty($request->id)) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong.'
            ]);
        }
    
        $data = Users_event_status::find($request->id);
    
        if (!$data) {
            return response()->json([
                'status' => 0,
                'message' => 'Staff record not found.'
            ]);
        }
    
        $event = Event::find($data->event_id);
    
        if (!$event) {
            return response()->json([
                'status' => 0,
                'message' => 'Event not found.'
            ]);
        }
    
        $today = date('Y-m-d'); // efine once
    
        if ($event->start_date <= $today && $event->end_date >= $today) {
            $data->event_status = 6;
        } else {
            $data->event_status = 5;
        }
    
        $data->save();
    
        return response()->json([
            'status' => 1,
            'message' => 'Staff has been accepted successfully.'
        ]);
    }
    public function reset_apply_staff(Request $request)
    {
        if (empty($request->id)) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong.'
            ]);
        }
    
        $data = Users_event_status::find($request->id);
    
        if (!$data) {
            return response()->json([
                'status' => 0,
                'message' => 'Staff record not found.'
            ]);
        }
    
        $event = Event::find($data->event_id);
    
        if (!$event) {
            return response()->json([
                'status' => 0,
                'message' => 'Event not found.'
            ]);
        }
    
            $data->event_status = 3;
      
        $data->save();
    
        return response()->json([
            'status' => 1,
            'message' => 'Staff application has been reset successfully.'
        ]);
    }
    public function reject_staff(Request $request)
    {
        if (!empty($request->id)) {
    
            $id = $request->id;
            
            $feedback = $request->feedback;
    
            $data = Users_event_status::find($id);
    
            if ($data) {
                $data->event_status = 4;
                $data->feedback = $feedback;
                if ($data->save()) {
                    return response()->json([
                        'status' => 1,
                        'message' => 'Staff has been rejected successfully.'
                    ]);
                }
            }
            return response()->json([
                'status' => 0,
                'message' => 'Staff rejected fail.'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' => 'something went wrong.'
            ]);
        }
    }
    public function export_confirm_staff(Request $request)
    {
        $fileName = 'confirm_staff.csv';
    
        $event_id = $request->event_id;
    
        $view_data = Users_event_status::where('event_id', $event_id)
            ->whereIn('event_status', [5, 6, 7])
            ->get();
    
        $columns = [
            'Event Name','Employee Id','First Name','Last Name','Email',
            'Phone','Gender','Date of birth','Nationality',
            'Where are you currently based','Areas Experience',
            'Additional Experience','How did you hear about us',
            'General Availability','English Level','How long have you been in Ireland','Role','Shift Name'
        ];
    
        $callback = function () use ($view_data, $columns) {
    
            $file = fopen('php://output', 'w');
    
            // UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
    
            fputcsv($file, $columns);
    
            foreach ($view_data as $val) {
    
                $event_name = $val->event ? $val->event->name : '';
                $event_role = $val->event ? $val->event->role : '';
    
                if ($val->user) {
    
                    $employee_id = 'EMP-' . $val->user->employee_id;
                    $phone = "+" . $val->user->country_code . ' ' . $val->user->phone;
    
                    $city = $val->user->city ? $val->user->city->name : '';
                    $english_level = $val->user->english_level ? $val->user->english_level->name : '';
                    $experience_level = $val->user->experience_level ? $val->user->experience_level->name : '';
    
                    $arr_exp = !empty($val->user->area_experience_occupations_id)
                        ? explode(',', $val->user->area_experience_occupations_id)
                        : [];
    
                    $occupations_arr = Occupations::whereIn('id', $arr_exp)->get();
    
                    $occupations = $occupations_arr->count() > 0
                        ? implode(',', $occupations_arr->pluck('name')->toArray())
                        : '';
    
                    $shift_name1=get_event_shift($val->id,$val->event_id);
                    $shift_name=implode(",", $shift_name1);
                    fputcsv($file, [
                        $event_name,
                        $employee_id,
                        $val->user->first_name,
                        $val->user->last_name,
                        $val->user->email,
                        $phone,
                        $val->user->gender,
                        $val->user->birth_date,
                        $val->user->nationality,
                        $city,
                        $occupations,
                        $val->user->additional_experience,
                        $val->user->hear_about_us,
                        $val->user->general_availability,
                        $english_level,
                        $experience_level,
                        $event_role,
                        $shift_name,
                    ]);
                }
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ]);
    }
    public function do_update_status_role(Request $request)
    {
        $input = $request->all();
    
        $rules['role_id'] = 'required';
		$messages['role_id.required']='role id is required';
    
		$rules['role'] = 'required';
		$messages['role.required']='Role is required';

	
		$validator = Validator::make($input, $rules,$messages);
    	if ($validator->passes()) {
    	    $role_id=$request->role_id;
		    $role=$request->role;
		    
		    $data = Users_event_status::find($role_id);
			$data->role=$role;
			if($data->save())
			{
                $json_data['status'] = 1;
                $json_data['message']    = 'Role updated successfully.';
                echo json_encode($json_data);
                exit;
			}else{
			    $json_data['status'] = 0;
				$json_data['message']    = 'Role updated fail.';
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
    public function accept_staff_mul(Request $request)
    {
        $ids = explode(',', $request->id);
        $events = Users_event_status::whereIn('id', $ids)->get();
        if ($events->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No records found!'
            ]);
        }
        
        foreach($ids as $key=>$val){
            
            
            
            $data = Users_event_status::find($val);
    
                if ($data) {
                    $event = Event::find($data->event_id);
                    if ($event) {
                        $today = date('Y-m-d'); // efine once
                
                        if ($event->start_date <= $today && $event->end_date >= $today) {
                            $data->event_status = 6;
                        } else {
                            $data->event_status = 5;
                        }
                    
                        $data->save();
                    }
                }
            
                
        }
        $json_data['status']=1;
		$json_data['message']	= 'Staff has been accepted successfully.';
		echo json_encode($json_data);
		exit;
    }
    public function assign_staff_single(Request $request)
    {
        $event_shift_id = $request->event_shift_id;
        $id = $request->id;
    
        if (empty($id)) {
            return response()->json([
                'status' => 0,
                'message' => 'No staff selected.'
            ]);
        }
    
        $data = Event_shift::find($event_shift_id);
    
        if (!$data) {
            return response()->json([
                'status' => 0,
                'message' => 'Shift not found.'
            ]);
        }
    
        // Existing IDs
        $arr_exist = [];
        if (!empty($data->users_event_status_id)) {
            $arr_exist = explode(",", $data->users_event_status_id);
        }
    
        // Avoid duplicate
        if (!in_array($id, $arr_exist)) {
            $arr_exist[] = $id;
        }
    
        // Save updated IDs
        $data->users_event_status_id = implode(',', $arr_exist);
    
        if ($data->save()) {
    
            // Event name
            $event_name = $data->event ? $data->event->name : '';
    
            $msg = "You have been assigned to ".$data->name." on ".$event_name.": ".$data->start_time." – ".$data->end_time.".";
    
            $data_u = Users_event_status::find($id);
    
            if (!empty($data_u)) {
                send_notification(0, $data_u->user_id, $data->event_id, 7, $msg, 0, 0);
    
                $url = route('dashboard');
                send_noti_fcm('Event confirmation', $msg, $data_u->user_id, $url);
            }
    
            return response()->json([
                'status' => 1,
                'message' => 'Shift assigned successfully.'
            ]);
        }
    
        return response()->json([
            'status' => 0,
            'message' => 'Shift assign failed.'
        ]);
    }
    public function remove_staff_single(Request $request)
    {
        $event_shift_id = $request->event_shift_id;
        $id = $request->id;
    
        if (empty($id)) {
            return response()->json([
                'status' => 0,
                'message' => 'No staff selected.'
            ]);
        }
    
        $data = Event_shift::find($event_shift_id);
    
        if (!$data) {
            return response()->json([
                'status' => 0,
                'message' => 'Shift not found.'
            ]);
        }
    
        // Existing IDs
        $arr_exist = [];
        if (!empty($data->users_event_status_id)) {
            $arr_exist = explode(",", $data->users_event_status_id);
        }
    
        // Remove ID
        if (($key = array_search($id, $arr_exist)) !== false) {
            unset($arr_exist[$key]);
        }
    
        // Re-index array (optional but clean)
        $arr_exist = array_values($arr_exist);
    
        // Save updated IDs
        $data->users_event_status_id = !empty($arr_exist) ? implode(',', $arr_exist) : null;
    
        if ($data->save()) {
    
            return response()->json([
                'status' => 1,
                'message' => 'Staff removed successfully.'
            ]);
        }
    
        return response()->json([
            'status' => 0,
            'message' => 'Staff remove failed.'
        ]);
    }
}
