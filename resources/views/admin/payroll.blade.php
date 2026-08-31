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
                            <div class="table-responsive payroll-table">
                                <table id="payrolltbl" class="table table-striped payrolltbl">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($arr_data as $key=>$val){ ?>
                                        <tr>
                                            <td><?php echo $val['week']; ?></td>
                                            <?php $week = strtolower(str_replace(' ', '_', $val['week'])); ?>
                                            <td><a href="{{ route('admin.payroll_details') }}?start_date=<?php echo $val['start_date']; ?>&&end_date=<?php echo $val['end_date']; ?>&&week=<?php echo $week; ?>">Payroll</a></td>
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
@endpush