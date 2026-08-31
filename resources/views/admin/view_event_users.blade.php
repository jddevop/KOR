@extends('admin.layouts.main')
@section('title')
    View Event Users
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-sm-12">
                        <div class="white-box">
                            @include('admin.layouts.partials.flash')
                            <div class="panel-heading m-b-15">
            						<h3 class="box-title ">Event Users</h3>
            						<a class="btn btn-info btn-rounded" href="javascript:void(0)" data-toggle="modal" data-target="#inviteUserModal"> Invite User</a>
            				</div>
                            
                           
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <tr>
                                                <th >No</th>
                                                <th>User Name</th>
                                                <th>Event Name</th>
                                                <th>Current Status</th>
                                               
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i=1)
				  						@foreach($view_data as $data)
                                        <tr >
                                            <td >{{ $i }}</td>
                                            <td><?php echo $data->first_name.' '.$data->last_name; ?></td>
                                            <td>{{ $data->event_name }}</td>
                                            <td>
                                                @if($data->event_status == 1)
                                                    <span class="label label-info">Invited</span>
                                                @elseif($data->event_status == 2)
                                                    <span class="label label-danger">Missed</span>
                                                @elseif($data->event_status == 3)
                                                    <span class="label label-success">Confirmed</span>
                                                @elseif($data->event_status == 4)
                                                    <span class="label label-warning">Ongoing</span>
                                                @elseif($data->event_status == 5)
                                                    <span class="label label-default">Concluded</span>
                                                @endif
                                            </td>
                                            
                                           
                                        </tr>
                                        @php($i++)
										@endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        </div>
        
        </div> 
<div class="modal fade" id="inviteUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Invite User to Event</h4>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
        
            <div class="form-group">
                <label>Select User</label>
                <select name="user_id" class="form-control" id="user_id">
                    <option value="">-- Select User --</option>
                    @foreach($all_users as $user)
                        <option value="{{ $user->id }}"><?php echo $user->first_name.' '.$user->last_name;?></option>
                    @endforeach
                </select>
                <div id="msg_user_id" class="text-danger err_msg"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" onclick="update_event_users_status()">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('custom-style')
<link href="{{ asset('asset/admin/swal/sweetalert.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .modal {
        text-align: center;
        padding: 0 !important;
    }
    .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
    }
    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }
</style>
@endpush
@push('custom-scripts')
    <script src="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
    $(function() {
        $('#myTable').DataTable();
    });
    
    </script>
<script src="{{ asset('asset/admin/swal/sweetalert.min.js') }}"></script>
<script type="text/javascript">
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content')
	}
});
$(document).on('click','.data_delete',function(){
	var id = $(this).data('id'); 
	swal({
			title: "Delete.",
			text: 'Are you sure You want to Delete ??',
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#ff9b44",
			confirmButtonText: "Yes",
			cancelButtonText: "No",
			closeOnConfirm: true,
			closeOnCancel: true
		}, function (isConfirm) {
			if (isConfirm) {
				 var token = $("meta[name='csrf-token']").attr("content");
				$.ajax( {
					type: "DELETE",
					url: 'event/'+id, 
					dataType: "json",
					data: {"id": id},
					success: function(response) {
						if(response.status==true)
						{
							location.reload();
						}else{
							alert("Error ! Data not deleted!");
						}	
					}
				});
		} else {
				//alert("GGG");
			}
		});
});
</script>
<script type="text/javascript">
    function update_event_users_status(){
        var event_id="<?php echo $event_id; ?>";
        var user_id = $("#user_id").val();
        var error = [];
            var i = 0;
    
        if (user_id == '') {
            error['msg_user_id'] = "User id Is Required";
            i++;
        }
        if (i < 1) {
            $.ajax({
                url: "{{ route('admin.update_event_users_status') }}",
                method: 'post',
                data: {
                    'user_id': user_id,
                    'event_id': event_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                beforeSend: function() {
                    
                },
                success: function(result) {
                    
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