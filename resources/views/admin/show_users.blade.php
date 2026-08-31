@extends('admin.layouts.main')

@section('title')
    Show User Details
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('users.index') }}" class="back-arrow-box"><i class="icon-arrow-left-circle"></i></a>
            <h3 class="page-header" style="margin-top:30px;">
                <i class="glyphicon glyphicon-user"></i> User Profile: <?php echo $data['first_name'].' '.$data['last_name']; ?>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                 <div class="row">

    <!-- Total Events -->
    <div class="col-md-6">
      <div class="panel panel-default text-center">
        <div class="panel-body" style="padding:10">
          <h6 class="text-muted">Total Events</h6>
          <h2 class="text-primary" id="totalEvents"><b><?php echo $totalEvents; ?></b></h2>
        </div>
      </div>
    </div>

    <!-- Previous Events Name -->
    <div class="col-md-6">
      <div class="panel panel-default text-center">
        <div class="panel-body" style="padding:10">
          <h6 class="text-muted">Previous Events Name</h6>
          <h2 class="text-success" id="workedEvents"><b><?php echo $last_event_name; ?></b></h2>
        </div>
      </div>
    </div>

  </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <a href="{{ asset('upload/users/'.$data->profile_picture) }}" target="_blank"><img src="{{ asset('upload/users/'.$data->profile_picture) }}" class="img-thumbnail img-responsive" style="margin: 0 auto; max-height: 200px;" alt="User Photo"></a>
                    <h4 style="margin-top:15px;"><?php echo $data['first_name'].' '.$data['last_name']; ?></h4>
                    <p class="text-muted"><?php echo $data['email'];?></p>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading"><b>Basic Information</b></div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
                            <th style="width:40%">Phone:</th>
                            <td>+<?php echo $data['country_code']; ?> <?php echo $data['phone']; ?></td>
                        </tr>
                        <tr>
                            <th>Gender:</th>
                            <td><?php echo $data['gender']; ?></td>
                        </tr>
                        <tr>
                            <th>D.O.B:</th>
                            <td><?php echo date('d-m-Y',strtotime($data['birth_date'])); ?></td>
                        </tr>
                        <?php if($data['pps_number']!=''){ ?>
                        <tr>
                            <th>PPS No:</th>
                            <td><span class="label label-default" style="color: #000;"><?php echo $data['pps_number']; ?></span></td>
                        </tr>
                        <?php }?>
                    </table>
                    
                    <hr style="margin: 10px 0;">
                    <p><b>Notes</b>  <a href="javascript:void(0)" class="pull-right" data-toggle="modal" data-target="#notesModal"><?php if($data['notes']==''){ ?>Add Notes <?php }else{?> Edit Notes <?php }?></a></p>
                    <p><?php echo $data['notes']; ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Experience & Skills</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Nationality:</b> <span class="label label-primary"><?php echo $data['nationality']; ?></span></p>
                            <p><b>Current City:</b> <?php if($data->city){ echo $data->city->name; } ?></p>
                            <?php if($data['nationality']=='EU' || $data['nationality']=='Non-EU'){ ?>
                                <p><b>In Ireland:</b> <?php if($data->experience_level){ echo $data->experience_level->name; } ?></p>
                            <?php }?>
                        </div>
                        
                        <div class="col-md-6">
                            <?php if($data['nationality']=='EU' || $data['nationality']=='Non-EU'){ ?>
                                <p><b>English Level:</b> <?php if($data->english_level){ echo $data->english_level->name; } ?></p>
                            <?php }?>
                            <p><b>How did you hear about us:</b> <?php echo $data->hear_about_us; ?></p>
                        </div>
                    </div>
                    <hr style="margin: 10px 0;">
                    <p><b>Experience Areas:</b></p>
                    
                    <?php foreach($occupations_arr as $key=>$val){ ?>
                        <span class="label label-info" style="padding: 5px 8px; display: inline-block; margin-bottom: 5px;"><?php echo $val['name']; ?></span>
                    <?php }?>
                    
                    <p style="margin-top: 10px;"><b>Availability:</b></p>
                    <?php $arr_gen = explode(',', $data['general_availability']); ?>
                    <?php foreach($arr_gen as $key=>$val){ ?>
                        <span class="label label-warning" style="padding: 5px 8px; display: inline-block;"><?php echo $val; ?></span>
                    <?php }?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><b>Additional Experience / Skills</b></div>
                <div class="panel-body">
                    <p><?php echo $data['additional_experience']; ?></p>
                </div>
            </div>
            <?php if(!empty($bank_data)){ ?>
            <div class="panel panel-default bank-details-card">
                <div class="panel-heading" style="background: #fff; border-bottom: none; padding-bottom: 0;">
                    <div class="pull-left"><b style="font-size: 16px;">Bank Details</b></div>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <table class="table custom-bank-table">
                        <tr>
                            <td class="text-muted">Account Holder name</td>
                            <td class="text-right"><b>{{ $bank_data['account_holder_name'] ?? '' }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Home Address</td>
                            <td class="text-right"><b>{{ $bank_data['home_address'] ?? '' }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-muted">IBAN</td>
                            <td class="text-right"><b>{{ $bank_data['iban'] ?? '' }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Bank Address</td>
                            <td class="text-right"><b>{{ $bank_data['bank_address'] ?? '' }}</b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php }?>
            <div class="panel panel-default">
                <div class="panel-heading"><b>Documents & Compliance</b></div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="active">
                                <th>Document Name</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data['nationality']=='Non-EU'){ ?>
                                <tr>
                                    <td>Work permit (Visa/GNIB)</td>
                                    <td>
                                        <?php if($data['expiry_date'] < date('Y-m-d')){ ?>
                                        <b class="text-danger"><?php echo date("d-m-Y",strtotime($data['expiry_date'])); ?></b>
                                        <?php }else{
                                        ?>
                                        <b ><?php echo date("d-m-Y",strtotime($data['expiry_date'])); ?></b>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                    <?php if($data['expiry_date']!=''){ if($data['expiry_date'] < date('Y-m-d')){?> <a href="javascript:void(0)" class="label label-danger font-weight-100">Expired</a> <?php }else{
                                        if($data['permission_to_work1_status']==0){ ?>
                                        
                                    <?php }else{
                                    ?>
                                        
                                    <?php
                                    }
                                    }}else{ if($data['permission_to_work1_status']==0){ ?>
                                        
                                    <?php }else{
                                    ?>
                                       
                                    <?php
                                    } }?>
                                    </td>
                                    <td class="text-center"><a href="{{ asset('upload/users/'.$data->permission_to_work1) }}" class="btn btn-xs btn-primary" target="_blank">View File</a>&nbsp;&nbsp;<?php if($data->permission_to_work2!=''){ ?><a href="{{ asset('upload/users/'.$data->permission_to_work2) }}" class="btn btn-xs btn-primary" target="_blank">View File</a><?php }?></td>
                                </tr>
                          <?php }?>
                          <?php if($data['passport']!=''){  ?>
                            <tr>
                                <td>Passport</td>
                                <td>N/A</td>
                                <td>
                                </td>
                                <td class="text-center"><a href="{{ asset('upload/users/'.$data->passport) }}" class="btn btn-xs btn-primary" target="_blank">View File</a></td>
                            </tr>
                            <?php }?>
                            <?php if($data['nationality']=='Irish' || $data['nationality']=='EU')
                            {
                               if($data['national_id']!=''){ 
                            ?>
                            <tr>
                                <td>National ID</td>
                                <td>N/A</td>
                                <td>
                                    
                                    
                                </td>
                                <td class="text-center"><a href="{{ asset('upload/users/'.$data->national_id) }}" class="btn btn-xs btn-primary" target="_blank">View File</a></td>
                            </tr>
                        <?php } }?>
                        <?php if($data['cv']!=''){  ?>
                            <tr>
                                <td>CV</td>
                                <td>N/A</td>
                                <td>
                                    
                                </td>
                                <td class="text-center"><a href="{{ asset('upload/users/'.$data->cv) }}" class="btn btn-xs btn-primary" target="_blank">View File</a> </td>
                            </tr>
                        <?php }?>
                        <?php if($data['other_relevant_document']!=''){  ?>
                            <tr>
                                <td>Other Relevant Document</td>
                                <td>N/A</td>
                                <td>
                                    
                                </td>
                                <td class="text-center"><a href="{{ asset('upload/users/'.$data->other_relevant_document) }}" class="btn btn-xs btn-primary" target="_blank">View File</a></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <div class="well well-sm" style="margin-top: 10px; background-color: #f9f9f9;">
                        <small><i class="glyphicon glyphicon-ok text-success"></i> User has consented to data storage and agreed to terms of employment.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document" style="display: flex; align-items: center; min-height: calc(100% - 60px);">
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php if($data['notes']==''){ ?>Add<?php }else{?>Edit<?php }?> Notes</h4>
            </div>
            <form id="editEmployerForm">
                <div class="modal-body">
                   
                    
                    <div class="form-group">
                        <label>Notes</label>
                        
                        <textarea name="notes" id="notes" class="form-control" rows="4"><?php echo $data['notes']; ?></textarea>
                        <div id="msg_notes" class="text-danger err_msg"></div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onClick="add_user_notes()">Submit</button>
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
<style>
    .page-header { margin-top: 0; }
    .panel { border-radius: 3px; border: 1px solid #ddd; }
    .panel-heading { font-weight: bold; }
    .label { font-size: 90%; }
   
</style>
@endpush
@push('custom-scripts')
    <script>
        function documents_status(document_name,status) {
            var id='<?php echo $data['id']; ?>';
                
                $.ajax({
                    url: "{{ route('admin.update_document_status') }}",
                    method: 'post',
                    data: {'id':id,'document_name':document_name,'status':status},
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
        }
        function add_user_notes(){
            var id = '<?php echo $data['id']; ?>';
           var notes = $("#notes").val();
           
            
            $(".err_msg").html('');
       
            var error = [];
            var i = 0;
    
            if (notes == '') {
                error['msg_notes'] = "Notes Is Required";
                i++;
            }
            if (i < 1) {
                $.ajax({
                url: "{{ route('admin.add_user_notes') }}",
                method: 'post',
                data: {
                    'id': id,
                    'notes': notes
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
