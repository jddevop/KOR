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
                                
                                <div class="panel-heading m-b-15">
            					<h3 class="box-title ">Search Users</h3>
            				</div>
                                    <form action="#">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Tags (multi-select)</label>
                                                        <select class="select2 m-b-10 select2-multiple" multiple="multiple" data-placeholder="Choose" name="tags_id1[]" id="tags_id1">
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
                                                        <label class="control-label">Occupation</label>
                                                        <select class="form-control" name="area_experience_occupations_id" id="area_experience_occupations_id">
                                                            <option value="">Select Occupation</option>
                                                            <?php foreach($occupations_data as $key=>$val){ ?>
                                                            <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                           <?php }?>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Experience Level</label>
                                                        <select class="form-control" name="experience_level_id" id="experience_level_id">
                                                            <option value="">Select Experience Level</option>
                                                            <?php foreach($experience_data as $key=>$val){ ?>
                                                            <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                           <?php }?>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-3 form-actions">
                                                    <label class="control-label" style="visibility:hidden">Buttons</label>
                                                    <div>
                                                        <button type="button" class="btn btn-success" onclick="get_search_users()"> <i class="fa fa-check"></i> Apply Filter</button>
                                                       
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>

                                    </form>


                            <div class="row">
                                
                                <div class="col-sm-12">
                                    <form>
                                     <button type="button" class="btn btn-primary af-btn" onclick="export_user()">Export</button>   
                                    </form>
                                </div>
                            </div>
                                    
                            <div class="row" style="display: flex;justify-content: end;">
                                
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="search" id="search_val" placeholder="Search" onkeyup="get_search_users()">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            
                                            <th>Tags</th>
                                            <th>PPS number</th>
                                            <th>IBAN</th>
                                            <th>Sort Code</th>
                                            <th>Bank Account Number</th>
                                            <th>Status</th>
                                            <th>Communication</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_user">
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="modal fade bs-example-modal-md" id="tagsModal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-md modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="myLargeModalLabel">Add Tags</h4> 
                                        </div>
                                        <div class="modal-body">
                                            <form action="#">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="">
                                                                <label class="control-label">Tags (multi-select)</label>
                                                                <select class="select2 m-b-10 select2-multiple" multiple="multiple" data-placeholder="Choose" name="tags_id[]" id="tags_id">
                                                                    <?php foreach($tags_data as $key=>$val){ ?>
                                                                    <option value="<?php echo $val['id']; ?>" selected><?php echo $val['name']; ?></option>
                                                                    <?php }?>
                                                                    
                                                                </select>
                                                                <input type="hidden" name="user_id" id="user_id">
                                                            </div>
                                                        </div>                                            
                                                        <div class="col-md-12" >
                                                            <button type="button" class="btn btn-danger waves-effect text-left" style="float:right;" onclick="add_tags()">Save</button>
                                                        </div>
                                                    </div> 
                                                </div> 
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
    .single-tag{letter-spacing: .05em;border-radius: 5px;padding: 4px 16px 3px;display: inline-block;font-weight: 500;font-size:12px;color:#fff;margin-bottom: 5px;margin-top: 5px;}
    .modal-dialog-centered {
    position: absolute;
    top: 45%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%) !important;
    }
.dataTables_filter{
        display:none;
    }
    .select2-container-multi .select2-choices{border:1px solid #e5ebec;}
    .af-btn{margin-top: 0px;float:right;margin-left: 10px;margin-bottom: 18px;}
    .af-btn-new{float:left;}
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
                    $('#showload').show();
                },
                success: function(result) {
                    $('#showload').hide();
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
    function add_users_tags(id){
        $.ajax({
            url: "{{ route('admin.get_tags') }}",
            method: 'post',
            data: {
                'user_id': id,
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
                        if ($('#tags_id').hasClass("select2-hidden-accessible")) {
                        $('#tags_id').select2('destroy');
                    }
    
                    // set new options
                    $('#tags_id').html(result.html);
    
                    // set user id
                    $('#user_id').val(id);
    
                    // re-init select2
                    $('#tags_id').select2({
                        width: '100%',
                        placeholder: "Choose"
                    });
    
                    // open modal
                    $('#tagsModal').modal('show');
                } else {
                    alert(result.message);
                }
            }
        });
    }
    function add_tags(){
        var user_id=$('#user_id').val();
        var selectedTags = $('#tags_id').val();
        
        /*if (!selectedTags || selectedTags.length === 0) {
            alert("Please select at least one tag");
            return;
        }*/
        
        $.ajax({
                url: "{{ route('admin.add_user_tags') }}",
                method: 'post',
                data: {
                    'user_id': user_id,
                    'tags_id': selectedTags && selectedTags.length ? selectedTags.join(',') : ''
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
                    $('#tagsModal').modal('hide');
                    if (result.status == 1) {
                        
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                }
            });
    }
jQuery(document).ready(function() {
    get_search_users();
});
function get_search_users(){
    
    var tags_id = $('#tags_id1').val(); // multi-select
    var english_level_id = $('#english_level_id').val();
    var area_experience_occupations_id = $('#area_experience_occupations_id').val();
    var experience_level_id = $('#experience_level_id').val();
    var search_val = $('#search_val').val();
    $.ajax({
        url: "{{ route('admin.get_search_users') }}",
        method: 'post',
        data: {
            tags_id: tags_id,
            english_level_id: english_level_id,
            area_experience_occupations_id: area_experience_occupations_id,
            experience_level_id: experience_level_id,
            search_val:search_val,
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
function export_user() {

    var tags_id = $('#tags_id1').val(); // multi-select
    var english_level_id = $('#english_level_id').val();
    var area_experience_occupations_id = $('#area_experience_occupations_id').val();
    var experience_level_id = $('#experience_level_id').val();
    var search_val = $('#search_val').val();

    var token = $("meta[name='csrf-token']").attr("content");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "{{ route('admin.export_user') }}", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", token);
    xhr.responseType = "blob";
    
    
    var formData = new FormData();

    // single values
    formData.append('english_level_id', english_level_id);
    formData.append('experience_level_id', experience_level_id);

    // multi-select (array)
    if (tags_id) {
        tags_id.forEach(function(val) {
            formData.append('tags_id[]', val);
        });
    }
    formData.append('area_experience_occupations_id', area_experience_occupations_id);
   formData.append('search_val', search_val);
    
    
    xhr.onload = function () {
        if (xhr.status === 200) {

            var blob = xhr.response;

            var link = document.createElement('a');
            var url = window.URL.createObjectURL(blob);

            link.href = url;
            link.download = "user.csv";

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

@endpush