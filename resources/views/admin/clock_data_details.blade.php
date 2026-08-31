@extends('admin.layouts.main')

@section('title')
    Payroll
@endsection

@section('content')
    <div class="container-fluid">
	    <div class="row">
        	<div class="col-sm-12">
        	    
                <div class="white-box">
                    <div class="panel-heading m-b-15">
            		    <h3 class="box-title ">Clock Data Management </h3>
            		</div>
            		<div class="row">
                                
                                <div class="col-sm-12">
                                    <form>
                                       <button type="button" class="btn btn-primary af-btn" onclick="export_clockin()">Export</button>   
                                    </form>
                                </div>
                            </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive payroll-table">
                                <table id="payrolltbl" class="table table-striped payrolltbl">
                                    <thead>
                                        <tr>
                                            <th>Staff full name</th>
                                            <th>Email address</th>
                                           <th>Event</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Clock In Note</th>
                                            <th>Clock Out Note</th>
                                            <th>Total Hours</th>
                                            <th>Shift Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($data as $key=>$val){ ?>
                                        <tr>
                                            <td><?php if($val->user){ echo $val->user->first_name.' '.$val->user->last_name; } ?></td>
                                            <td><?php if($val->user){ echo $val->user->email; } ?></td>
                                            <td><?php if($val->event){ echo $val->event->name; } ?></td>
                                            
                                            <td><?php if($val->clock_in_date_time!=''){ echo date("Y-m-d H:i",strtotime($val->clock_in_date_time));}?></td>
                                            <td><?php if($val->clock_out_date_time!=''){ echo date("Y-m-d H:i",strtotime($val->clock_out_date_time));}?></td>
                                            <td><?php echo $val->clock_in_explanatory_note;?></td>
                                            <td><?php echo $val->clock_out_explanatory_note;?></td>
                                            <td><?php if($val->clock_in_date_time!='' && $val->clock_out_date_time!=''){ echo getTimeDifference($val->clock_in_date_time,$val->clock_out_date_time); }?></td>
                                            <td><?php $shift_data=get_clockdata_shift($val->user_id,$val->event_id); 
                                                foreach($shift_data as $val1){
                                                    echo date('h:i A', strtotime($val1['start_time'])).' to '.date('h:i A', strtotime($val1['end_time']))."</br>";
                                                }
                                            ?></td>
                                            <td><a href="javascript:void(0)" onclick="edit_clock(
'{{ $val->id }}',
'{{ \Carbon\Carbon::parse($val->clock_in_date_time)->format('Y-m-d\TH:i') }}',
'{{ \Carbon\Carbon::parse($val->clock_out_date_time)->format('Y-m-d\TH:i') }}'
)">Edit Clock</a></td>
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
    <div>
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" >
        @csrf
        <input type="hidden" name="id" id="edit_id">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Time</h4>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Clock In</label>
            <input type="datetime-local" name="clock_in" id="clock_in" class="form-control">
            <div id="msg_clock_in" class="text-danger err_msg"></div>
          </div>

          <div class="form-group">
            <label>Clock Out</label>
            <input type="datetime-local" name="clock_out" id="clock_out" class="form-control">
            <div id="msg_clock_out" class="text-danger err_msg"></div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-success" onClick="edit_clockin_clockout()">Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection

@push('custom-style')
<link href="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .mt-25{margin-top:25px;}
    .mb-25{margin-bottom:25px;}
    .fit-width{width:fit-content;}
    .float-right{float:right;}
    .d-none{display:none;}
</style>
<style>
    .af-btn{margin-top: 0px;float:right;margin-left: 10px;margin-bottom: 18px;}
    .af-btn-new{float:left;}
</style>

@endpush
@push('custom-scripts')
    <script src="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        $(function() {
            $('#payrolltbl').DataTable({
            ordering: false
        });
        });        
    </script>
    <script>
    function export_clockin() {
    var from_date = '<?php echo $start_date; ?>';
    var to_date = '<?php echo $end_date; ?>';
    var file_name='<?php echo $week; ?>';
    var token = $("meta[name='csrf-token']").attr("content");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "{{ route('admin.export_clockin') }}", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", token);
    xhr.responseType = "blob";

    var formData = new FormData();
    formData.append('from_date', from_date);
     formData.append('to_date', to_date);
    

    xhr.onload = function () {
        if (xhr.status === 200) {

            var blob = xhr.response;

            var link = document.createElement('a');
            var url = window.URL.createObjectURL(blob);

            link.href = url;
            link.download = file_name+".csv";

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
function edit_clock(id,clock_in_date_time,clock_out_date_time){
 
    
    $('#edit_id').val(id);
    $('#clock_in').val(clock_in_date_time);
    $('#clock_out').val(clock_out_date_time);

    $('#editModal').modal('show');
}
function edit_clockin_clockout(){
       
        var edit_id = $("#edit_id").val();
        var clock_in = $("#clock_in").val();
        var clock_out = $("#clock_out").val();
        
        $(".err_msg").html('');
   
        var error = [];
        var i = 0;

        if (clock_in == '') {
            error['msg_clock_in'] = "Clock In Is Required";
            i++;
        }
        
        if (clock_out == '') {
            error['msg_clock_out'] = "Clock Out Is Required";
            i++;
        }
        
        let inTime = new Date(clock_in);
        let outTime = new Date(clock_out);
    
        // validation
        if (outTime < inTime) {
            
             error['msg_clock_out'] = "Clock out must be greater than or equal to clock in";
            i++;
        }
        
        if (i < 1) {
            $.ajax({
            url: "{{ route('admin.edit_clockin_clockout') }}",
            method: 'post',
            data: {
                'id': edit_id,
                'clock_in': clock_in,
                'clock_out': clock_out
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
</script>
@endpush