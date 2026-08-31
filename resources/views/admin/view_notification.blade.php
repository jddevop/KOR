@extends('admin.layouts.main')
@section('title')
    View Notifications 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-sm-12">
                        <div class="white-box">
                            @include('admin.layouts.partials.flash')
                            <div class="panel-heading m-b-15">
            						<h3 class="box-title ">Notifications</h3>
            						
            				</div>
                            
                           
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th >No</th>
                                            <th>User</th>
                                            <th>Message</th>
                                            <th>Time</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i=1)
				  						@foreach($view_data as $data)
                                        <tr >
                                            <td >{{ $i }}</td>
                                            <td><?php if($data->user){ echo $data->user->first_name.' '.$data->user->last_name; } ?></td>
                                            <td><?php echo $data['message']; ?></td>
                                            <td><?php echo date('d M, h:i A',strtotime($data['date_time'])); ?></td>
                                            <td><a href="javascript:void(0)" data-id="{{ $data->id }}" class="data_delete"><i class="fa fa-trash"></i></a></td>
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
@endsection
@push('custom-style')
<link href="{{ asset('asset/admin/swal/sweetalert.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
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
					url: 'notification/'+id, 
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
@endpush