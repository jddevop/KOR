@extends('admin.layouts.main')
@section('title')
    View Event 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-sm-12">
                        <div class="white-box">
                            @include('admin.layouts.partials.flash')
                           <div class="panel-heading m-b-15">
            						<h3 class="box-title ">Event</h3>
            						<a class="btn btn-info btn-rounded" href="{{ route('event.create') }}"> Add Event</a>
            				</div>
            				
            				<form action="#">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Status</label>
                                                        <select class="form-control" name="status" id="status">
                                                         <option value="">Select Status</option>
                                                         <option value="upcoming">Upcoming</option>
                                                         <option value="ongoing">Ongoing</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">From Date</label>
                                                       <input type="date" class="form-control" name="from_date" id="from_date" min="{{ date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">To Date</label>
                                                        <input type="date" class="form-control" name="to_date" id="to_date" min="{{ date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 form-actions">
                                                    <label class="control-label" style="visibility:hidden">Buttons</label>
                                                    <div>
                                                        <button type="button" class="btn btn-success" onclick="get_search_event()"> <i class="fa fa-check"></i> Apply Filter</button>
                                                       
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>

                                    </form>
            				
            				
                            <div class="row">
                                
                                <div class="col-sm-12">
                                    <form>
                                     <button type="button" class="btn btn-primary af-btn" onclick="export_event()">Export</button>   <button type="button" class="btn btn-success af-btn af-btn-new" onclick="delete_event()">Delete</button>
                                    </form>
                                </div>
                            </div>
                           
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> <input type="checkbox" id="selectAll" class="check"> </th>
                                            <th >Name</th>
                                            <th >Address</th>
                                            <th>Payment Rate</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Confirmed Staff / Total Required</th>
                                            <th>WhatsApp Group Link</th>
                                            <th >Status</th>
											<th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_event">
                                        
                                    </tbody>
                                </table>
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
<link href="{{ asset('asset/admin/swal/sweetalert.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .select2-container-multi .select2-choices{border:1px solid #e5ebec;}
    .af-btn{margin-top: 0px;float:right;margin-left: 10px;margin-bottom: 18px;}
    .af-btn-new{float:left;}
</style>
@endpush
@push('custom-scripts')
    <script src="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
    $(function() {
         $('#myTable').DataTable({
            ordering: false
        });
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
$(document).ready(function() {
    // 1. Handle "Select All" click
    $('#selectAll').on('click', function() {
        var isChecked = $(this).prop('checked');
        // Select all checkboxes in the table body
        $('#myTable tbody .check').prop('checked', isChecked);
    });

    // 2. If a single checkbox is unchecked, uncheck the "Select All" checkbox
    $('#myTable tbody').on('click', '.check', function() {
        if ($('#myTable tbody .check:checked').length == $('#myTable tbody .check').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });
});
function delete_event(){
    var selectedIds = [];
        $('#myTable tbody .check:checked').each(function() {
            // Assuming the ID is stored in the delete button or a data attribute on the row
            selectedIds.push($(this).closest('tr').find('.data_delete').data('id'));
        });

        if (selectedIds.length > 0) {
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
    					type: "POST",
    					url: "{{ route('admin.event_delete') }}", 
    					dataType: "json",
    					data: {"id": selectedIds.join(',')},
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
				
        			}
        		});     
           
        } else {
            alert("Please select at least one user.");
        }
}
function export_event() {

    var status = $('#status').val();
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();

    var token = $("meta[name='csrf-token']").attr("content");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "{{ route('admin.export_event') }}", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", token);
    xhr.responseType = "blob";

    var formData = new FormData();


    formData.append('status', status);
    formData.append('from_date', from_date);
     formData.append('to_date', to_date);
    

    xhr.onload = function () {
        if (xhr.status === 200) {

            var blob = xhr.response;

            var link = document.createElement('a');
            var url = window.URL.createObjectURL(blob);

            link.href = url;
            link.download = "events.csv";

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


jQuery(document).ready(function() {
    get_search_event();
});
function get_search_event(){
    var status = $('#status').val();
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    
    $.ajax({
        url: "{{ route('admin.get_search_event') }}",
        method: 'post',
        data: {
            status: status,
            from_date: from_date,
            to_date: to_date,
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
                    if ($.fn.DataTable.isDataTable('#myTable')) {
                        $('#myTable').DataTable().destroy();
                    }
                    $('#show_event').html(result.html_data);
                     $('#myTable').DataTable({
                        ordering: false
                    }); // re-init
            } else {
               
            }
        }
    });
}
</script>
@endpush