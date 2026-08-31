@extends('admin.layouts.main')
@section('title')
    View Saved Event 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-sm-12">
                        <div class="white-box">
                            @include('admin.layouts.partials.flash')
                            <div class="panel-heading m-b-15">
            						<h3 class="box-title ">Saved Event</h3>
            						
            				</div>
                            
                           
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User Name</th>
                                            <th>Event</th>
                                           
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i=1)
				  						@foreach($view_data as $data)
                                        <tr >
                                            <td >{{ $i }}</td>
                                            <td><?php if($data->user){  echo $data->user->first_name.' '.$data->user->last_name; } ?></td>
                                            <td><?php if($data->event){  echo $data->event->name; } ?></td>
                                            <td><?php if($data->event){  echo date("d-m-Y",strtotime($data->event->start_date)); } ?></td>
                                            <td><?php if($data->event){  echo date("d-m-Y",strtotime($data->event->end_date)); } ?></td>
                                            
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
@endpush