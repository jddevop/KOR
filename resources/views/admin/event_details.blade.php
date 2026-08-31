@extends('admin.layouts.main')
@section('title')
    View Event 
@endsection
@section('content')
<div class="container-fluid">
    <a href="{{ route('event.index') }}" class="back-arrow-box"><i class="icon-arrow-left-circle"></i></a>
    <h2 class="mb-5"><?php echo $event_name; ?></h2>
    <div class="row colorbox-group-widget">
        <div class="col-xs-2-event info-color-box">
            <div class="white-box">
                <div class="media bg-primary">
                    <div class="media-body">
                        <h3 class="info-count"><?php echo $inviteuserCount; ?> <span class="pull-right"><i class="mdi mdi-account-plus"></i></span></h3>
                        <p class="info-text">Invited</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-2-event info-color-box">
            <div class="white-box">
                <div class="media bg-warning">
                    <div class="media-body">
                        <h3 class="info-count"><?php echo $applayuserCount; ?> <span class="pull-right"><i class="mdi mdi-account-alert"></i></span></h3>
                        <p class="info-text">Applied</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xs-2-event info-color-box">
            <div class="white-box">
                <div class="media bg-danger">
                    <div class="media-body">
                        <h3 class="info-count"><?php echo $rejectuserCount; ?> <span class="pull-right"><i class="mdi mdi-account-remove"></i></span></h3>
                        <p class="info-text">Refused</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-2-event info-color-box">
            <div class="white-box">
                <div class="media bg-success">
                    <div class="media-body">
                        <h3 class="info-count"><?php echo $confirmuserCount; ?> <span class="pull-right"><i class="mdi mdi-account-check"></i></span></h3>
                        <p class="info-text">Confirmed</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-2-event  info-color-box">
            <div class="white-box">
                <div class="media bg-info">
                    <div class="media-body">
                        <h3 class="info-count"><?php echo $ongoinguserCount; ?> <span class="pull-right"><i class="mdi mdi-account"></i></span></h3>
                        <p class="info-text">Active</p>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    
    <div class="row ed-link-box">
        <div class="col-sm-12">
            <a href="{{ route('admin.search_event_users') }}?id=<?php echo $event_id; ?>" class="btn btn-block btn-primary imu-btn">Invite More Users</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-10">
                        <h3 class="box-title">Shift List</h3> 
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:void(0)" class="btn btn-block btn-primary" data-toggle="modal" data-target=".addshift">Add Shift</a>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="shifttable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Timing</th>
                                        
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($view_shift as $key=>$val){ ?>
                                    <tr>
                                        <td><?php echo $val['name']; ?></td>
                                        <td><?php echo date("h:i A",strtotime($val['start_time'])); ?> to <?php echo date("h:i A",strtotime($val['end_time'])); ?></td>
                                        
                                        
                                        <td>
                                            
                                            <a href="javascript:void(0)" onClick="get_staff('<?php echo $val['id']; ?>')">Manage Staff</a>&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" onClick="edit_shift('<?php echo $val['id']; ?>')">Edit Shift</a>&nbsp;&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                <?php }?>                                  
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>
                
             </div>
        </div>
    </div>
 
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="box-title">Applied Staff</h3> 
                    </div>
                    <div class="col-sm-12">
                                    <form>
                                        <button type="button" class="btn btn-success af-btn"  onclick="accept_staff_mul()"> Accept Staff</button>
                                    </form>
                                </div>
                </div>                
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="conftable" class="table table-striped conftabl">
                                <thead>
                                    <tr>
                                        <th> <input type="checkbox" id="selectAll" class="check"> </th>
                                        <th>Employee Id</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Tags</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($applied_data as $key=>$val){ 
                                    if($val->user)
                                    {
                                ?>
                                    <tr>
                                       <td><input type="checkbox" class="check" data-id="{{ $val->id }}"></td>
                                        <td>EMP-<?php echo $val->user->id; ?></td>
                                        <td> <a href="{{ route('users.show',$val->user->id) }}" target="_blank"><?php echo $val->user->first_name; ?></a></td>
                                        <td><a href="{{ route('users.show',$val->user->id) }}" target="_blank"><?php echo $val->user->last_name; ?></a></td>
                                        <td><?php echo $val->user->email; ?></td>
                                        <td>+<?php echo $val->user->country_code; ?> <?php echo $val->user->phone; ?></td>
                                        <td>
                                            <?php if($val->user->tags_id!=''){  
                                            $tags_arr=get_users_tags($val->user->tags_id);
                                            foreach($tags_arr as $key=>$val1){
                                        ?>
                                            <span class="single-tag" style="background-color:<?php echo $val1['color']; ?>;"><?php echo $val1['name']; ?></span> 
                                        <?php } }?>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="accept_staff('<?php echo $val->id; ?>')">
                                                Accept
                                            </a>                                            
                                            <a href="javascript:void(0)" onclick="rejected_staff('<?php echo $val->id; ?>')">
                                                Reject
                                            </a>
                                        </td>
                                    </tr>
                                <?php } }?>
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>                
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                            
                <div class="row">
                    <div class="col-md-10">
                        <h3 class="box-title">Accepted Staff</h3> 
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary af-btn btn-block" onclick="export_confirm_staff()">Export</button>   
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="conftable" class="table table-striped conftabl">
                                <thead>
                                    <tr>
                                        <th>Employee Id</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Tags</th>
                                        <th>Role</th>
                                        <th>Shift Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($accepted_data as $key=>$val){ 
                                    if($val->user)
                                    {
                                ?>
                                    <tr>
                                        <td>EMP-<?php echo $val->user->id; ?></td>
                                        <td><?php echo $val->user->first_name; ?></td>
                                        <td><?php echo $val->user->last_name; ?></td>
                                        <td><?php echo $val->user->email; ?></td>
                                        <td>+<?php echo $val->user->country_code; ?> <?php echo $val->user->phone; ?></td>
                                        <td>
                                            <?php if($val->user->tags_id!=''){  
                                            $tags_arr=get_users_tags($val->user->tags_id);
                                            foreach($tags_arr as $key=>$val1){
                                        ?>
                                            <span class="single-tag" style="background-color:<?php echo $val1['color']; ?>;"><?php echo $val1['name']; ?></span> 
                                        <?php } }?>
                                        </td>
                                       <td>
                                           <?php if($val->role==''){ if($val->event){ echo $val->event->role; } }else{ echo $val->role;  } ?> <a href="javascript:void(0);" onclick="update_status_role('<?php echo $val->id; ?>')">Add</a>
                                           </td>
                                       <td>
                                           <?php $arr_shift=get_event_shift($val->id,$val->event_id); 
                                           echo implode(",", $arr_shift);
                                           ?>
                                       </td>
                                       <td>
                                           <?php if($val->event_status==5){ ?>
                                            <a href="javascript:void(0)" onclick="reset_apply_staff('<?php echo $val->id; ?>')">
                                                Reset to Applied
                                            </a>                                            
                                           <?php }?>
                                        </td>
                                    </tr>
                                <?php } }?>
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>                
            </div>
        </div>
    </div>
    
     <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="box-title">Rejected Staff</h3> 
                    </div>
                </div>                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="conftable" class="table table-striped conftabl">
                                <thead>
                                    <tr>
                                        <th>Employee Id</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Tags</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($rejected_data as $key=>$val){ 
                                    if($val->user)
                                    {
                                ?>
                                    <tr>
                                       
                                        <td>EMP-<?php echo $val->user->id; ?></td>
                                        <td><?php echo $val->user->first_name; ?></td>
                                        <td><?php echo $val->user->last_name; ?></td>
                                        <td><?php echo $val->user->email; ?></td>
                                        <td>+<?php echo $val->user->country_code; ?> <?php echo $val->user->phone; ?></td>
                                        <td>
                                            <?php if($val->user->tags_id!=''){  
                                            $tags_arr=get_users_tags($val->user->tags_id);
                                            foreach($tags_arr as $key=>$val){
                                        ?>
                                            <span class="single-tag" style="background-color:<?php echo $val['color']; ?>;"><?php echo $val['name']; ?></span> 
                                        <?php } }?>
                                        </td>
                                       
                                    </tr>
                                <?php } }?>
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>                
            </div>
        </div>
    </div>
                            <div class="modal fade addshift" tabindex="-1" role="dialog" aria-labelledby="addshift" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="addshift">Create Shift</h4> 
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-md-12">Shift Name</span></label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Shift Name"> 
                                                        <div id="msg_name" class="text-danger err_msg"></div>
                                                    </div>
                                                </div>                                                
                                                <div class="form-group">
                                                    <label class="col-md-12">Start Time</span></label>
                                                    <div class="col-md-12">
                                                        <input type="time" class="form-control" name="start_time" id="start_time" placeholder="Start Time"> 
                                                        <div id="msg_start_time" class="text-danger err_msg"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12">End Time</span></label>
                                                    <div class="col-md-12">
                                                        <input type="time" class="form-control" name="end_time" id="end_time" placeholder="Start Time"> 
                                                        <div id="msg_end_time" class="text-danger err_msg"></div>
                                                    </div>
                                                </div>  
                                                <div class="row">
                                                    <div class="col-sm-6 col-sm-offset-3">
                                                        <button type="button" class="btn btn-block btn-success" onClick="add_shift()">Submit</button>  
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="modal fade editshift" tabindex="-1" id="editshift" role="dialog" aria-labelledby="editshift" aria-hidden="true" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="editshift">Edit Shift</h4> 
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-md-12">Shift Name</span></label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" name="edit_name" id="edit_name" placeholder="Shift Name"> 
                                                        <input type="hidden" name="edit_id" id="edit_id" >
                                                        <div id="msg_edit_name" class="text-danger err_msg"></div>
                                                    </div>
                                                </div>                                                
                                                <div class="form-group">
                                                    <label class="col-md-12">Start Time</span></label>
                                                    <div class="col-md-12">
                                                        <input type="time" class="form-control" name="edit_start_time" id="edit_start_time" placeholder="Start Time">
                                                        <div id="msg_edit_start_time" class="text-danger err_msg"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12">End Time</span></label>
                                                    <div class="col-md-12">
                                                        <input type="time" class="form-control" name="edit_end_time" id="edit_end_time" placeholder="Start Time"> 
                                                        <div id="msg_edit_end_time" class="text-danger err_msg"></div>
                                                    </div>
                                                </div>  
                                                <div class="row">
                                                    <div class="col-sm-6 col-sm-offset-3">
                                                        <button type="button" class="btn btn-block btn-success" onClick="update_shift()">Submit</button>  
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="modal fade delstaff" id="delstaff" tabindex="-1" role="dialog" aria-labelledby="delstaff" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="delstaff">Feedback</h4> 
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label class="col-md-12">Feedback</label>
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="reject_staff_id" id="reject_staff_id">
                                                        <textarea class="form-control" rows="5" name="feedback" id="feedback"></textarea>
                                                        <div id="msg_feedback" class="text-danger err_msg"></div>
                                                    </div>
                                                </div>     
                                                <div class="row">
                                                    <div class="col-md-12 del-submit">
                                                        <button type="button" onClick="reject_staff()" class="btn btn-block btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>                             
                            
                            
                            <div class="modal fade managestaff" id="managestaff" tabindex="-1" role="dialog" aria-labelledby="managestaff" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="managestaff">Manage Staff</h4> 
                                        </div>
                                        <div class="modal-body">
                                            
                                            <div class="row" style="display: flex;justify-content: end;">
                                
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="search" id="search_val" placeholder="Search" onkeyup="get_search_shift_staff()">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive manage-staff-table">
                                                        <table id="manstaff" class="table table-striped">
                                                            <thead>
                                                                
                                                                <tr>
                                                                    <th><?php /*<input type="checkbox" id="selectAll1" class="check">*/?>
                                                                    <input type="hidden" name="event_shift_id" id="event_shift_id">
                                                                    </th>
                                                                    <th>Employee Id</th>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Email</th>
                                                                    <th>Phone</th>
                                                                    <th>Tags</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="show_shift">
                                                                                                                       
                                                            </tbody>
                                                        </table>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <?php /*<div class="row">
                                                <div class="col-sm-12">
                                                    <button type="button" class="btn btn-block btn-primary as-btn" onClick="assign_staff()">Assign Staff</button>            
                                                </div>
                                            </div>*/?>
                                        </div>
                                    </div>
                                </div>
                            </div>                             



                            <div class="modal fade delstaff" id="rolestaff" tabindex="-1" role="dialog" aria-labelledby="rolestaff" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="delstaff">Role</h4> 
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label class="col-md-12">Role</label>
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="role_id" id="role_id">
                                            
                                                        <input type="text" class="form-control" name="role" id="role" placeholder="Role" >
                                                        <div id="msg_role" class="text-danger err_msg"></div>
                                                    </div>
                                                </div>     
                                                <div class="row">
                                                    <div class="col-md-12 del-submit">
                                                        <button type="button" onClick="do_update_status_role()" class="btn btn-block btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


</div>
<div class="loadingClass" id="showload">
        <img src="{{ asset('asset/admin/images/loader.gif') }}" alt="loader" />
    </div>
@endsection
@push('custom-style')
<link href="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    .col-xs-2-event{
        width: 20%;
        float: left;
        padding-left: 15px;
        padding-right: 15px;        
    }
    .ed-link-box{
        margin-bottom:30px;
    }
 
    .single-tag {
        letter-spacing: .05em;
        border-radius: 5px;
        padding: 4px 16px 3px;
        display: inline-block;
        font-weight: 500;
        font-size: 12px;
        color: #fff;
        margin-bottom: 5px;
        margin-top: 5px;
    }    
    .staff-info{
        background-color: #f4f8f9;
        border: 1px solid #e5e5e5;        
    }
    .staff-info h5{
        padding-left:15px;
        padding-right:15px;
    }
    .as-btn{
        width: fit-content;
        float: right;
    }
    .conftabl a{
        margin-right:15px;
    }
    .imu-btn{
        width: fit-content;
        float: right;
    }
    .del-submit{
        justify-content: center;
        align-items: center;
        display: flex;        
    }
    .del-submit button{
        margin-top:15px;
        width:fit-content;
    }



.manage-staff-table {
  max-height: 400px;
  overflow-y: auto;
}

.manage-staff-table table {
  width: 100%;
}

.manage-staff-table thead th {
  position: sticky;
  top: 0;
  background-color:#FFF;
}


    
    
    
.modal {
  text-align: center;
  padding: 0 !important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}    
#manstaff_wrapper{
    margin:30px 0;
}    
    
    
    @media (min-width: 0px) {
      .col-xs-2-event { width: 100%; float: left; }
    }     
    @media (min-width: 576px) {
      .col-xs-2-event { width: 50%; float: left; }
    }    
    @media (min-width: 768px) {
        .col-xs-2-event { width: 33.33%; float: left; }
        .modal-dialog-centered {
            position: absolute;
            top: 45%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%) !important;
        }        
    }
    @media (min-width: 992px) {
      .col-xs-2-event { width: 33.33%; float: left; }
    }
    @media (min-width: 1200px) {
      .col-xs-2-event { width: 20%; float: left; }
    }    
    
    
    
    
    
</style>
@endpush
@push('custom-scripts')
    <script src="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
     
<script>
    function add_shift(){
        var event_id='<?php echo $event_id; ?>';
       
        var name = $("#name").val();
        var start_time = $("#start_time").val();
        var end_time = $("#end_time").val();
        
        $(".err_msg").html('');
   
        var error = [];
        var i = 0;

        if (name == '') {
            error['msg_name'] = "Shift Name Is Required";
            i++;
        }
        
        if (start_time == '') {
            error['msg_start_time'] = "Start Time Is Required";
            i++;
        }
        if (end_time == '') {
            error['msg_end_time'] = "End Time Is Required";
            i++;
        }
        
        if (i < 1) {
            $.ajax({
            url: "{{ route('admin.add_shift') }}",
            method: 'post',
            data: {
                'event_id': event_id,
                'name': name,
                'start_time': start_time,
                'end_time': end_time
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function() {
                $('#showload').show();
            },
            success: function(result) {
                $('#showload').hide();
                if (result.status == 1) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
        }else{
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
        }
}
function edit_shift(id){
    $.ajax({
        url: "{{ route('admin.edit_shift') }}",
        method: 'post',
        data: {
            'id': id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        beforeSend: function() {
            $('#showload').show();
        },
        success: function(result) {
            $('#showload').hide();
            if (result.status == 1) {
                $('#edit_id').val(result.data.id);
                $('#edit_name').val(result.data.name);
                $('#edit_start_time').val(result.data.start_time);
                $('#edit_end_time').val(result.data.end_time);
                $('#editshift').modal('show');
            } else {
                
            }
        }
    });
}
function update_shift(){
        var edit_id=$("#edit_id").val();
        var name = $("#edit_name").val();
        var start_time = $("#edit_start_time").val();
        var end_time = $("#edit_end_time").val();
        
        $(".err_msg").html('');
   
        var error = [];
        var i = 0;

        if (name == '') {
            error['msg_edit_name'] = "Shift Name Is Required";
            i++;
        }
        
        if (start_time == '') {
            error['msg_edit_start_time'] = "Start Time Is Required";
            i++;
        }
        if (end_time == '') {
            error['msg_edit_end_time'] = "End Time Is Required";
            i++;
        }
        
        if (i < 1) {
            $.ajax({
            url: "{{ route('admin.update_shift') }}",
            method: 'post',
            data: {
                'edit_id': edit_id,
                'name': name,
                'start_time': start_time,
                'end_time': end_time
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function() {
                $('#showload').show();
            },
            success: function(result) {
                $('#showload').hide();
                if (result.status == 1) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
        }else{
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
        }
}
function get_staff(id){
    var event_id='<?php echo $event_id; ?>';
    $.ajax({
        url: "{{ route('admin.get_staff') }}",
        method: 'post',
        data: {
            'id': id,
            'event_id':event_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        beforeSend: function() {
            $('#showload').show();
        },
        success: function(result) {
            $('#showload').hide();
            if (result.status == 1) {
                $('#event_shift_id').val(id);
                $('#show_shift').html(result.html_data);
                $('#managestaff').modal('show');
            } else {
                
            }
        }
    });
    
}
function get_search_shift_staff(){
    var id=$('#event_shift_id').val();
    var event_id='<?php echo $event_id; ?>';
    var search_val = $('#search_val').val();
    $.ajax({
        url: "{{ route('admin.get_staff') }}",
        method: 'post',
        data: {
            'id': id,
            'event_id':event_id,
            'search_val':search_val
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        beforeSend: function() {
            $('#showload').show();
        },
        success: function(result) {
            $('#showload').hide();
            if (result.status == 1) {
                $('#event_shift_id').val(id);
                $('#show_shift').html(result.html_data);
               
            } else {
                
            }
        }
    });
}
function assign_staff() {
    var event_shift_id = $("#event_shift_id").val();

    var staff_ids = $('input[name="assign_staff[]"]:checked')
        .map(function () {
            return $(this).val();
        }).get();

    if (staff_ids.length > 0) {
        $.ajax({
            url: "{{ route('admin.assign_staff') }}",
            method: 'POST',
            data: {
                event_shift_id: event_shift_id,
                assign_staff: staff_ids
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function () {
                $('#showload').show();
            },
            success: function (result) {
                $('#showload').hide();

                if (result.status == 1) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
    } else {
        alert('Please select staff');
    }
}
function accept_staff(id) {

        $.ajax({
            url: "{{ route('admin.accept_staff') }}",
            method: 'POST',
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function () {
                $('#showload').show();
            },
            success: function (result) {
                $('#showload').hide();

                if (result.status == 1) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
   
}
function reset_apply_staff(id){
    $.ajax({
            url: "{{ route('admin.reset_apply_staff') }}",
            method: 'POST',
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function () {
                $('#showload').show();
            },
            success: function (result) {
                $('#showload').hide();

                if (result.status == 1) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
}
function rejected_staff(id) {
    $("#reject_staff_id").val(id);
    $('#delstaff').modal('show');
}
function do_update_status_role(){
    var role_id=$("#role_id").val();
        var role = $("#role").val();
        
        $(".err_msg").html('');
   
        var error = [];
        var i = 0;

        if (role == '') {
            error['msg_role'] = "Role Is Required";
            i++;
        }
        
       
        if (i < 1) {
            $.ajax({
            url: "{{ route('admin.do_update_status_role') }}",
            method: 'post',
            data: {
                'role_id': role_id,
                'role': role
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function() {
                $('#showload').show();
            },
            success: function(result) {
                $('#showload').hide();
                if (result.status == 1) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
        }else{
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
        }
}
function reject_staff() {
    var id = $("#reject_staff_id").val();
    var feedback = $("#feedback").val();
    
    $(".err_msg").html('');
   
    var error = [];
    var i = 0;

    if (feedback == '') {
        error['msg_feedback'] = "Feedback Is Required";
        i++;
    }
    if (i < 1) {
        $.ajax({
            url: "{{ route('admin.reject_staff') }}",
            method: 'POST',
            data: {
                id: id,
                feedback:feedback
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function () {
                $('#showload').show();
            },
            success: function (result) {
                $('#showload').hide();
    
                if (result.status == 1) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
    }else{
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
    }
}
function update_status_role(id){
    $('#role_id').val(id);
     $('#rolestaff').modal('show');
}
</script> 
<script type="text/javascript">
$(document).ready(function() {
    // 1. Handle "Select All" click
    $('#selectAll1').on('click', function() {
        var isChecked = $(this).prop('checked');
        // Select all checkboxes in the table body
        $('#manstaff tbody .check').prop('checked', isChecked);
    });

    // 2. If a single checkbox is unchecked, uncheck the "Select All" checkbox
    $('#manstaff tbody').on('click', '.check', function() {
        if ($('#manstaff tbody .check:checked').length == $('#manstaff tbody .check').length) {
            $('#selectAll1').prop('checked', true);
        } else {
            $('#selectAll1').prop('checked', false);
        }
    });
});


function export_confirm_staff() {

    var event_id = '<?php echo $event_id; ?>';
     var event_name = '<?php echo $event_name; ?>';


    var token = $("meta[name='csrf-token']").attr("content");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "{{ route('admin.export_confirm_staff') }}", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", token);
    xhr.responseType = "blob";
    
    
    var formData = new FormData();

    // single values
    formData.append('event_id', event_id);

    xhr.onload = function () {
        if (xhr.status === 200) {

            var blob = xhr.response;

            var link = document.createElement('a');
            var url = window.URL.createObjectURL(blob);

            link.href = url;
            link.download = event_name;

            document.body.appendChild(link);
            link.click();

            setTimeout(function () {
                window.URL.revokeObjectURL(url);
                document.body.removeChild(link);
            }, 100);
        }
    };

    xhr.send(formData);
}
</script> 
<script type="text/javascript">

$(document).ready(function() {
    // 1. Handle "Select All" click
    $('#selectAll').on('click', function() {
        var isChecked = $(this).prop('checked');
        // Select all checkboxes in the table body
        $('#conftable tbody .check').prop('checked', isChecked);
    });

    // 2. If a single checkbox is unchecked, uncheck the "Select All" checkbox
    $('#conftable tbody').on('click', '.check', function() {
        if ($('#myTable tbody .check:checked').length == $('#myTable tbody .check').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });
});

function accept_staff_mul(){
  
    var selectedIds = [];
        $('#conftable tbody .check:checked').each(function() {
            // Assuming the ID is stored in the delete button or a data attribute on the row
            selectedIds.push($(this).data('id'));
        });

        if (selectedIds.length > 0) {
            var token = $("meta[name='csrf-token']").attr("content");
				$.ajax( {
					type: "POST",
					url: "{{ route('admin.accept_staff_mul') }}", 
					dataType: "json",
					data: {"id": selectedIds.join(',')},
					success: function(response) {
						if(response.status==true)
						{
							location.reload();
						}else{
							alert("Error ! Data not invited!");
						}	
					}
				});
        }else{
            alert("Please select at least one user.");
        }
}

</script>
<script>
$(document).on('change', '.checkfun', function() {
    let userId = $(this).data('id');
    let isChecked = $(this).is(':checked');
    var event_shift_id = $("#event_shift_id").val();
    if(isChecked){
        var token = $("meta[name='csrf-token']").attr("content");
		$.ajax( {
			type: "POST",
			url: "{{ route('admin.assign_staff_single') }}", 
			dataType: "json",
			 beforeSend: function() {
                $('#showload').show();
            },
			data: {"id": userId,"event_shift_id":event_shift_id},
			success: function(response) {
			    $('#showload').hide();
				if(response.status==true)
				{
				    
				}else{
					alert("Error ! Data not invited!");
				}	
			}
		});
    }else{
        var token = $("meta[name='csrf-token']").attr("content");
		$.ajax( {
			type: "POST",
			url: "{{ route('admin.remove_staff_single') }}", 
			dataType: "json",
			 beforeSend: function() {
                $('#showload').show();
            },
			data: {"id": userId,"event_shift_id":event_shift_id},
			success: function(response) {
			    $('#showload').hide();
				if(response.status==true)
				{
				    
				}else{
					alert("Error ! Data not invited!");
				}	
			}
		});  
    } 
});
</script>
@endpush