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
            		    <h3 class="box-title ">Payroll Management </h3>
            		</div>
            		<div class="row">
                                
                                <div class="col-sm-12">
                                    <form>
                                     <button type="button" class="btn btn-primary af-btn" onclick="export_payroll()">Export</button>   
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
                                           
                                            <th>PPS number</th>
                                            <th>IBAN</th>
                                            <th>Sort Code</th>
                                            <th>Bank Account Number</th>
                                            <th>Home Address</th>
                                            <th>Hours worked</th>
                                            <th>Total payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($data as $key=>$val){ ?>
                                        <tr>
                                            <td><?php if($val->user){ echo $val->user->first_name.' '.$val->user->last_name; } ?></td>
                                            <td><?php if($val->user){ echo $val->user->email; } ?></td>
                                            <td><?php if($val->user){ echo $val->user->pps_number; } ?></td>
                                            <td><?php $bank=get_users_bank_detail($val->user_id); echo str_replace(' ', '', $bank); ?></td>
                                            <td><?php echo substr(str_replace(' ', '',$bank), 8,6);?></td>
                                            <td><?php echo substr(str_replace(' ', '', $bank), 14); ?></td>
                                            <td><?php $home_add=get_users_bank_detail_home($val->user_id); echo $home_add; ?></td>
                                            <td><?php echo get_shift_hours_payroll($val->user_id,$start_date,$end_date); ?></td>
                                            <td>€<?php 
$total = get_shift_hours_payroll_min($val->user_id,$start_date,$end_date);

echo round($total,2);
?></td>
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
    function export_payroll() {
    var from_date = '<?php echo $start_date; ?>';
    var to_date = '<?php echo $end_date; ?>';
    var file_name='<?php echo $week; ?>';
    var token = $("meta[name='csrf-token']").attr("content");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "{{ route('admin.export_payroll') }}", true);
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
</script>
@endpush