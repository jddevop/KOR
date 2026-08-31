<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Notification;
use Validator;
use DB;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main_menu='notification';
		$sub_menu='notification';
		
		Notification::where('notification_type', 1)
                ->where('status', 0)
                ->update(['status' => 1]);
		
        $view_data=Notification::where('notification_type',1)->orderBy('id', 'desc')->get();
        
        
        
        return view('admin.view_notification',['main_menu'=>$main_menu,'sub_menu'=>$sub_menu,'view_data' => $view_data]);
    }

    public function destroy($id)
    {
        $data = Notification::find($id); 
        if($data->delete()){          
            $result = array('status' => true, 'message' => 'Success!', 'result' => '');
        }else{
          $result = array('status' => false, 'message' => 'Fail!', 'result' => '');  
        }
        echo json_encode($result);
        exit;
    }

}
