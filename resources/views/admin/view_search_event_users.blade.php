@extends('admin.layouts.main')
@section('title')
    View Users 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-sm-12">
                        <div class="white-box">
                            @include('admin.layouts.partials.flash')
                            <div class="event-detai-box">
                             <a href="{{ route('event.index') }}" class="back-arrow-box"><i class="icon-arrow-left-circle"></i></a>
                             
                             <a href="{{ route('admin.event_details') }}?id=<?php echo $event_id; ?>" class=" btn-primary imu-btn go_to_event">Go to Event</a>
                             </div>
                            <div class="panel-heading m-b-15">
                               
            					<h3 class="box-title ">Search Users</h3>
            				</div>


                                    <form action="#">
                                        <div class="form-body">

                                            <div class="row">
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Tags (multi-select)</label>
                                                        <select class="select2 m-b-10 select2-multiple" multiple="multiple" data-placeholder="Choose" name="tags_id[]" id="tags_id">
                                                            <?php foreach($tags_data as $key=>$val){ ?>
                                                            <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                            <?php }?>
                                                            
                                                        </select>                                                        
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">English Level</label>
                                                        <select class="form-control" name="english_level_id" id="english_level_id">
                                                         <option value="">Select English Level</option>
                                                        <?php foreach($english_level_data as $key=>$val){ ?>
                                                        <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                        <?php }?>
                                                        </select> 
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Nationality</label>
                                                        <select class="form-control" name="nationality" id="nationality">
                                                            <option value="">Select Nationality</option>
                                                            <option value="Irish">Irish</option>
                                                            <option value="EU">EU</option>
                                                            <option value="Non-EU">Non-EU</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Gender</label>
                                                        <select class="form-control" name="gender" id="gender">
                                                            <option value="">Select Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Experience Level</label>
                                                        <select class="form-control" name="area_experience_occupations_id" id="area_experience_occupations_id">
                                                            <option value="">Select Experience Level</option>
                                                           <?php foreach($occupations_data as $key=>$val){ ?>
                                                            <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                           <?php }?>
                                                        </select> 
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Location</label>
                                                        <select class="form-control" name="city_id" id="city_id">
                                                            <option value="">Select Location</option>
                                                        <?php foreach($city_data as $key=>$val){ ?>
                                                            <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                        <?php }?>
                                                        </select> 
                                                    </div>
                                                </div>                                                
                                                
                                               <?php /* <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Age</label>
                                                        <select class="form-control">
                                                            <option value="">Male</option>
                                                            <option value="">Female</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Attendance metrics</label>
                                                        <select class="form-control">
                                                            <option value="">Male</option>
                                                            <option value="">Female</option>
                                                        </select> 
                                                    </div>
                                                </div>   
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Performance flags</label>
                                                        <select class="form-control">
                                                            <option value="">Male</option>
                                                            <option value="">Female</option>
                                                        </select> 
                                                    </div>
                                                </div>  */?>
                                                
                                                <div class="col-md-3 form-actions">
                                                    <label class="control-label" style="visibility:hidden">Buttons</label>
                                                    <div>
                                                        <button type="button" class="btn btn-success" onclick="get_search_event_users()"> <i class="fa fa-check"></i> Apply Filter</button>
                                                       
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>

                                    </form>


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel-heading">
                    					<h3 class="box-title ">Users</h3>
                    				</div>                                    
                                </div>
                                <?php /*<div class="col-sm-12">
                                    <form>
                                        <button type="button" class="btn btn-success af-btn"  onclick="invite_user()"> Invite User</button>
                                    </form>
                                </div>*/?>
                            </div>


                            <div class="row" style="display: flex;justify-content: end;">
                                
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="search" id="search_val" placeholder="Search" onkeyup="get_search_event_users()">
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> <?php /*<input type="checkbox" id="selectAll" class="check">*/?> </th>
                                            <th>Employee Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_user">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        </div>
        
        </div> 
        
        
<div class="modal fade" id="employerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document" style="display: flex; align-items: center; min-height: calc(100% - 60px);">
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Employer Details</h4>
            </div>
            <form id="editEmployerForm">
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="user_id">
                    
                    <div class="form-group">
                        <label>Employer Name</label>
                        <input type="text" class="form-control" id="employer_name" name="employer_name">
                        <div id="msg_employer_name" class="text-danger err_msg"></div>
                    </div>
                    <div class="form-group">
                        <label>Employer Number</label>
                        <input type="text" class="form-control" id="employer_number" name="employer_number">
                        <div id="msg_employer_number" class="text-danger err_msg"></div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="employer_email" name="employer_email">
                        <div id="msg_employer_email" class="text-danger err_msg"></div>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" class="form-control" id="employer_contact_number" name="employer_contact_number">
                        <div id="msg_employer_contact_number" class="text-danger err_msg"></div>
                    </div>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-primary" onClick="edit_emp()">Submit</button>
                </div>
            </form>
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
<link href="{{ asset('asset/admin/plugins/components/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('asset/admin/plugins/components/switchery/dist/switchery.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('asset/admin/plugins/components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
    
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .select2-container-multi .select2-choices{border:1px solid #e5ebec;}
    .af-btn{margin-top: 0px;float:left;margin-bottom:30px;}
    .dataTables_filter{
        display:none;
    }
</style>
@endpush
@push('custom-scripts')
    <script src="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
     
    <script>
    $(function() {
         $('#myTable').DataTable({
            ordering: false
        });
    });
    
    </script>
<script src="{{ asset('asset/admin/swal/sweetalert.min.js') }}"></script>
<script type="text/javascript">

jQuery(document).ready(function() {
    $(".select2").select2();
    get_search_event_users();
});

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
					url: 'users/'+id, 
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
    function getEmp(id){
        $.ajax({
                url: "{{ route('admin.get_employer') }}",
                method: 'post',
                data: {
                    'id': id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                beforeSend: function() {
                    
                },
                success: function(result) {
                    
                    if (result.status == 1) {
                        $('#user_id').val(id);
                        $('#employer_name').val(result.data.employer_name);
                        $('#employer_number').val(result.data.employer_number);
                        $('#employer_email').val(result.data.email);
                        $('#employer_contact_number').val(result.data.contact_number);
                        $('#employerModal').modal('show');
                    } else {
                        $('#user_id').val('');
                        $('#employer_name').val('');
                        $('#employer_number').val('');
                        $('#employer_email').val('');
                        $('#employer_contact_number').val('');
                    }
                }
            });
        
    }
    
    function edit_emp(){
           var user_id = $("#user_id").val();
            var employer_name = $("#employer_name").val();
            var employer_number = $("#employer_number").val();
            var employer_email = $("#employer_email").val();
            var employer_contact_number = $("#employer_contact_number").val();
            $(".err_msg").html('');
       
            var error = [];
            var i = 0;
    
            if (employer_name == '') {
                error['msg_employer_name'] = "Employer Name Is Required";
                i++;
            }
            
            if (employer_number == '') {
                error['msg_employer_number'] = "Employer Number Is Required";
                i++;
            }
            if (employer_email == '') {
        		error['msg_employer_email'] = "Email Is Required";
        		i++;
        	} else {
        		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        		if (!regex.test(employer_email)) {
        			error['msg_employer_email'] = "the Email is incorrect";
        			i++;
        		}
        	}
        	
        	if (employer_contact_number == '') {
                error['msg_employer_contact_number'] = "Contact Number Is Required";
                i++;
            }
            
            if (i < 1) {
                $.ajax({
                url: "{{ route('admin.add_employer') }}",
                method: 'post',
                data: {
                    'id': user_id,
                    'employer_name': employer_name,
                    'employer_number': employer_number,
                    'employer_contact_number': employer_contact_number,
                    'employer_email': employer_email,
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
<script type="text/javascript">
function get_search_event_users(){
    var event_id="<?php echo $event_id; ?>";
    var tags_id = $('#tags_id').val(); // multi-select
    var english_level_id = $('#english_level_id').val();
    var nationality = $('#nationality').val();
    var gender = $('#gender').val();
    var area_experience_occupations_id = $('#area_experience_occupations_id').val();
    var city_id = $('#city_id').val();
    var search_val = $('#search_val').val();
    
    $.ajax({
        url: "{{ route('admin.get_search_event_users') }}",
        method: 'post',
        data: {
            event_id:event_id,
            tags_id: tags_id,
            english_level_id: english_level_id,
            nationality: nationality,
            gender: gender,
            area_experience_occupations_id: area_experience_occupations_id,
            city_id: city_id,
            search_val:search_val
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

        $('#show_user').html(result.html_data);

         $('#myTable').DataTable({
            ordering: false
        }); // re-init
              
            } else {
               
            }
        }
    });
}
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
function invite_user(){
    var event_id="<?php echo $event_id; ?>";
    var selectedIds = [];
        $('#myTable tbody .check:checked').each(function() {
            // Assuming the ID is stored in the delete button or a data attribute on the row
            selectedIds.push($(this).data('id'));
        });

        if (selectedIds.length > 0) {
            var token = $("meta[name='csrf-token']").attr("content");
				$.ajax( {
					type: "POST",
					url: "{{ route('admin.invite_user') }}", 
					dataType: "json",
					data: {"id": selectedIds.join(','),"event_id":event_id},
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
    var event_id="<?php echo $event_id; ?>";
    if(isChecked){
        var token = $("meta[name='csrf-token']").attr("content");
		$.ajax( {
			type: "POST",
			url: "{{ route('admin.invite_user_single') }}", 
			dataType: "json",
			 beforeSend: function() {
                $('#showload').show();
            },
			data: {"id": userId,"event_id":event_id},
			success: function(response) {
			    $('#showload').hide();
				if(response.status==true)
				{
				    
				    $('#show_td'+userId).html('<span class="label label-info">Invited</span>')
					//location.reload();
				}else{
					alert("Error ! Data not invited!");
				}	
			}
		});
    } 
});
</script>
@endpush