@extends('admin.layouts.main')

@section('title')
    Annual Leave
@endsection

@section('content')
    <div class="container-fluid">
	    <div class="row">
        	<div class="col-sm-12">
        	    
                <div class="white-box">
                    <div class="panel-heading m-b-15">
            		    <h3 class="box-title ">Annual Leave Requests</h3>
            		</div>

                    
            		
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive payroll-table">
                                <table id="payrolltbl" class="table table-striped payrolltbl">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Request Date</th>
                                            <th>Hours Requested</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach($annual_data as $key=>$val){ ?>  
                                        <tr>
                                            <td><?php if($val->user){ echo $val->user->first_name.' '.$val->user->last_name; } ?></td>
                                            <td><?php echo date("d M Y", strtotime($val['date'])); ?></td>
                                            <td><?php echo $val['annual_leave']; ?> Hour</td>
                                            <td>
                                                <a href="javascript:void(0)" onClick="annual_leave_approve('<?php echo $val['id']; ?>')">Approve</a>&nbsp;&nbsp;
                                                <a href="javascript:void(0)" onClick="annual_leave_reject('<?php echo $val['id']; ?>')">Reject</a>&nbsp;&nbsp;
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
        	<div class="col-sm-12">
        	    
                <div class="white-box">
                    <div class="panel-heading m-b-15">
            		    <h3 class="box-title ">Annual Leave Paid</h3>
            		</div>

                    
            		
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive payroll-table">
                                <table id="payrolltbl1" class="table table-striped payrolltbl">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Request Date</th>
                                            <th>Hours Requested</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach($annual_paid_data as $key=>$val){ ?>  
                                        <tr>
                                            <td><?php if($val->user){ echo $val->user->first_name.' '.$val->user->last_name; } ?></td>
                                            <td><?php echo date("d M Y", strtotime($val['date'])); ?></td>
                                            <td><?php echo $val['annual_leave']; ?> Hour</td>
                                            
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
        	<div class="col-sm-12">
        	    
                <div class="white-box">
                    <div class="panel-heading m-b-15">
            		    <h3 class="box-title ">Annual Leave Rejected</h3>
            		</div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive payroll-table">
                                <table id="payrolltbl1" class="table table-striped payrolltbl">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Request Date</th>
                                            <th>Hours Requested</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach($annual_rejected_data as $key=>$val){ ?>  
                                        <tr>
                                            <td><?php if($val->user){ echo $val->user->first_name.' '.$val->user->last_name; } ?></td>
                                            <td><?php echo date("d M Y", strtotime($val['date'])); ?></td>
                                            <td><?php echo $val['annual_leave']; ?> Hour</td>
                                            
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
<div class="loadingClass" id="showload">
    <img src="{{ asset('asset/admin/images/loader.gif') }}" alt="loader" />
</div>
@endsection

@push('custom-style')
<link href="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .mt-25{margin-top:25px;}
    .mr-15{margin-right:15px;}
    .mb-25{margin-bottom:25px;}
    .fit-width{width:fit-content;}
    .float-right{float:right;}
    .d-none{display:none;}
    
    .alr-btn-wrap{display: flex;align-items: center;justify-content: flex-start;}
    
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
        $(function() {
            $('#payrolltbl1').DataTable({
            ordering: false
        });
        });   
    </script>
    <script type="text/javascript">
    function annual_leave_approve(id){
        $.ajax({
                url: "{{ route('admin.annual_leave_approve') }}",
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
                       alert(result.message);
                       window.location.href = "{{ route('annual_leave.index') }}";
                    } else {
                        alert(result.message);
                    }
                }
            });
        
    }
    function annual_leave_reject(id){
        $.ajax({
                url: "{{ route('admin.annual_leave_reject') }}",
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
                       alert(result.message);
                       window.location.href = "{{ route('annual_leave.index') }}";
                    } else {
                        alert(result.message);
                    }
                }
            });
    }
</script>
@endpush