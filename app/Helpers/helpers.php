<?php
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use App\Models\Users_event_status;
use App\Models\Users_shift;
use App\Models\Tags;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\Bank_account_details;
use App\Models\User;
use App\Models\Event_shift;
use Google\Client as GoogleClient;

if (! function_exists('send_notification')) {   
    function send_notification($from_id,$to_id,$event_id,$type,$message,$notification_type,$status) {
        $ins=new Notification;
	    $ins->from_id=$from_id;
	    $ins->to_id=$to_id;
	    $ins->event_id=$event_id;
	    $ins->type=$type;
	    $ins->message=$message;
	    $ins->notification_type=$notification_type;
	    $ins->status=$status;
	    $ins->date=date('Y-m-d');
	    $ins->time=date('H:i:s');
	    $ins->date_time=date('Y-m-d H:i:s');
	    $ins->save();
    }
}
if (!function_exists('send_noti_fcm')) {   
    function send_noti_fcm($title, $message, $id,$click_action) { 

        $data_user = User::where('id', $id)->first();

        if (!empty($data_user) && !empty($data_user->token)) {

            $token = $data_user->token;

           
            $projectId = 'kornotification'; 
            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

            
            $credentialsPath = "/home/korpwapprojectjd/public_html/public/firebase-auth.json"; 

            
            $client = new GoogleClient();
            $client->setAuthConfig($credentialsPath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->fetchAccessTokenWithAssertion();
            $accessToken = $client->getAccessToken()['access_token'];

            $headers = [
                "Authorization: Bearer " . $accessToken,
                "Content-Type: application/json"
            ];

            $icon = asset('asset/images/apple-touch-icon.png'); 
            $postRequest = [
                "message" => [
                    "token" => $token,
                    "data" => [
                        "title" => $title,
                        "body" => $message,
                        "user_id" => (string)$id,
                        "icon" => $icon,
                        "click_action" => $click_action,
                    ]
                ]
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postRequest));

            $season_data = curl_exec($ch);
            
            if (curl_errno($ch)) {
                print "Error: " . curl_error($ch);
                exit();
            }
            
            curl_close($ch);
            
           
            $json = json_decode($season_data, true);
            //echo '<pre>'; print_r($json); exit;
        }
    }
}

if (!function_exists('calculateHours')) {
    function calculateHours($start, $end)
    {
        $startTime = new DateTime($start);
        $endTime   = new DateTime($end);

        $interval = $startTime->diff($endTime);

        $hours=$interval->h + ($interval->i / 60);
        return $hours . " hrs";
    }
}
if (!function_exists('get_event_status')) {
    function get_event_status($id)
    {
        $user_data = session('user_data');
        $user_id = $user_data ? $user_data->id : null;
       $status=0;
       $data = Users_event_status::where('user_id', $user_id)->where('event_id', $id)->first();

		if(!empty($data))
		{ 
		    $status=$data->event_status;
		}
		return $status;
    }
}
if (!function_exists('get_event_shift')) {
    function get_event_shift($id,$event_id)
    {
         $view_shift = Event_shift::where('event_id', $event_id)
        ->whereRaw("FIND_IN_SET(?, users_event_status_id)", [$id])
        ->get();
        $arr=array();
        foreach($view_shift as $key=>$val)
        {
            $arr[]=$val->name;
        }
        return $arr;
    }
}
if (!function_exists('get_shift_hours')) {
    function get_shift_hours()
    {
        $user_data = session('user_data');
        $user_id = $user_data ? $user_data->id : null;
        
        $data_shift = Users_shift::where('user_id',$user_id)->get();
        $totalMinutes = 0;

        foreach($data_shift as $shift) {
            if($shift->clock_in_date_time && $shift->clock_out_date_time) {
                
                $seconds = Carbon::parse($shift->clock_in_date_time)
                            ->diffInSeconds($shift->clock_out_date_time);
        
                $totalMinutes += ceil($seconds / 60); // round up
            }
        }
        
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $total_hours = sprintf('%02d', $hours);
		return $total_hours;
    }
}
if (!function_exists('get_shift_hours_min')) {
    function get_shift_hours_min()
    {
        $user_data = session('user_data');
        $user_id = $user_data ? $user_data->id : null;
        
        $data_shift = Users_shift::where('user_id',$user_id)->get();
        
        $totalMinutes = 0;

        foreach($data_shift as $shift) {
            if($shift->clock_in_date_time && $shift->clock_out_date_time) {
                
                $seconds = Carbon::parse($shift->clock_in_date_time)
                            ->diffInSeconds($shift->clock_out_date_time);
        
                $totalMinutes += ceil($seconds / 60); // round up
            }
        }
        
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        $total_hours = sprintf('%02dh %02dm', $hours, $minutes);
        
        
		return $total_hours;
    }
}
if (!function_exists('get_users_tags')) {
    function get_users_tags($tags_id)
    {
        $ids = explode(',', $tags_id);
       
        $data_tags = Tags::whereIn('id', $ids)->get();
       
        if(!empty($data_tags))
        {
            return $data_tags;
        }else{
            return array();
        }
        
    }
}
if (!function_exists('get_event_status_count')) {
    function get_event_status_count($id)
    {
        $user_data = session('user_data');
        $user_id = $user_data ? $user_data->id : null;

        $count = Users_event_status::where('event_id', $id)
            ->whereIn('event_status', [3, 5, 6, 7])
            ->count();

        return $count;
    }
}
if (!function_exists('get_assign_staff')) {
    function get_assign_staff($users_event_status_id)
    {
        $arr_exp = !empty($users_event_status_id) 
            ? explode(',', $users_event_status_id) 
            : [];

        $user_arr = Users_event_status::with('user')
            ->whereIn('id', $arr_exp)
            ->get();

        $staff = '';

        if ($user_arr->count() > 0) {
            $names = [];

            foreach ($user_arr as $val) {
                if (!empty($val->user)) {
                    $names[] = $val->user->first_name . ' ' . $val->user->last_name;
                }
            }

            $staff = implode(', ', $names);
        }

        return $staff;
    }
}
if (!function_exists('get_users_bank_detail')) {
    function get_users_bank_detail($user_id)
    {
        $data_bank = Bank_account_details::where('user_id', $user_id)->get()->first();
        $iban='';
        if(!empty($data_bank))
        {
            $iban=$data_bank->iban;
        }
        return $iban;
    }
}
if (!function_exists('get_users_bank_detail_home')) {
    function get_users_bank_detail_home($user_id)
    {
        $data_bank = Bank_account_details::where('user_id', $user_id)->get()->first();
        $home_address='';
        if(!empty($data_bank))
        {
            $home_address=$data_bank->home_address;
        }
        return $home_address;
    }
}
if (!function_exists('get_clockdata_shift')) {
    function get_clockdata_shift($user_id, $event_id)
    {
        $arr = [];

        // Step 1: users_event_status ni IDs levu
        $statusIds = Users_event_status::where('user_id', $user_id)
            ->where('event_id', $event_id)->get()->first();
    
        if (!empty($statusIds)) {
            // Step 2: shift fetch karvu
            $view_shift = Event_shift::where('event_id', $event_id)->WhereRaw("FIND_IN_SET(?, users_event_status_id)", [$statusIds->id])->get();
            
            foreach ($view_shift as $val) {
                $arr[] = [
                    'start_time' => $val->start_time,
                    'end_time'   => $val->end_time
                ];
            }
        }

        return $arr;
    }
}
if (!function_exists('get_users_bank_detail_account_holder_name')) {
    function get_users_bank_detail_account_holder_name($user_id)
    {
        $data_bank = Bank_account_details::where('user_id', $user_id)->get()->first();
        $account_holder_name='';
        if(!empty($data_bank))
        {
            $account_holder_name=$data_bank->account_holder_name;
        }
        return $account_holder_name;
    }
}
if (!function_exists('get_shift_hours_payroll')) {
    function get_shift_hours_payroll($user_id,$start_date,$end_date)
    {
        $data_shift = Users_shift::whereBetween('clock_in_date', [$start_date, $end_date])->where('user_id',$user_id)->get();
        $totalMinutes = 0;

        $totalMinutes = 0;

        foreach($data_shift as $shift) {
            if($shift->clock_in_date_time && $shift->clock_out_date_time) {
                
                $seconds = Carbon::parse($shift->clock_in_date_time)
                            ->diffInSeconds($shift->clock_out_date_time);
        
                $totalMinutes += ceil($seconds / 60); // round up
            }
        }
        
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        $total_hours = sprintf('%02d:%02d', $hours, $minutes);
        
        
		return $total_hours;
    }
}
if (!function_exists('get_shift_hours_payroll_min')) {
function get_shift_hours_payroll_min($user_id, $start_date, $end_date)
{
    $shifts = Users_shift::where('user_id', $user_id)
        ->whereBetween('clock_in_date', [$start_date, $end_date])
        ->get();

    $total = 0;

    foreach($shifts as $shift) {
            if($shift->clock_in_date_time && $shift->clock_out_date_time) {
                
                $seconds = Carbon::parse($shift->clock_in_date_time)
                            ->diffInSeconds($shift->clock_out_date_time);
        
                $totalMinutes = ceil($seconds / 60); // round up
                
                if($shift->event){
                    if($shift->event->payment_rate >0){
                        $amount = ($totalMinutes / 60) * $shift->event->payment_rate;
                        $total=$total+$amount;
                    }
                }
                
            }
        }

    return $total;
}
}
if (!function_exists('get_time_percentage')) {
function get_time_percentage($time, $percent)
{
    list($hours, $minutes) = explode(':', $time);

    // total minutes
    $totalMinutes = ($hours * 60) + $minutes;

    // apply %
    $newMinutes = ($totalMinutes * $percent) / 100;

    // IMPORTANT FIX
    $newMinutes = round($newMinutes); // round

    // convert back to HH:MM
    $newHours = floor($newMinutes / 60);
    $remainMinutes = $newMinutes % 60;

    return str_pad($newHours, 2, '0', STR_PAD_LEFT) . ':' . 
           str_pad($remainMinutes, 2, '0', STR_PAD_LEFT);
}
}
function timeAgo($datetime)
{
    $time = strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60) {
        return 'now';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' min ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour ago';
    } elseif ($diff < 172800) {
        return 'Yesterday';
    } elseif ($diff < 604800) { // 7 days
        $days = floor($diff / 86400);
        return $days . ' days ago';
    } elseif ($diff < 2592000) { // 30 days
        $weeks = floor($diff / 604800);
        return $weeks . ' week ago';
    } elseif ($diff < 31536000) { // 12 months
        $months = floor($diff / 2592000);
        return $months . ' month ago';
    } else {
        $years = floor($diff / 31536000);
        return $years . ' year ago';
    }
}
function getTimeDifference($start, $end)
{
    $startTime = \Carbon\Carbon::parse($start);
    $endTime = \Carbon\Carbon::parse($end);

    $minutes = $startTime->diffInMinutes($endTime);

    $hours = floor($minutes / 60);
    $mins = $minutes % 60;

    return sprintf('%02d:%02d', $hours, $mins);
}