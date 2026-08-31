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
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 class="box-title m-b-0">Tags</h3>
                                    <p class="text-muted m-b-30">Data table example</p>                                    
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ route('tags.create') }}" class="btn btn-block btn-primary add-tab-btn">Add Tag</a>        
                                </div>
                            </div>

                            
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tags Name</th>
                                            <th>Tags Color</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Premium</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                            <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Level 1</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Level 2</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Level 3</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>5</td>                                            
                                            <td>Level 4</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Level 5</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Reliable</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Requires Attention</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Do Not Hire</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>No-Show Risk</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>11</td>
                                            <td>Frequently Late</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td>Rehire Recommended</td>
                                            <td><div class="color-box" style="background-color:#ff0000;"></div></td>
                                           <td>
												<div class="onoffswitch" >
												<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick" data-table="tags" value="1">
												<label class="onoffswitch-label" for="switch_sick">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
												</div>                                                
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;<a href="javascript:void(0)" class="data_delete"><i class="fa fa-trash"></i></a>
                                            </td>                                            
                                        </tr>                                        
                                        


 

                                    </tbody>
                                </table>
                            </div>


                    </div>
                </div>
            </div>
        </div>


@endsection

@push('custom-style')

<link href="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<style>
.add-tab-btn{width: fit-content;float: right;}
.color-box{width: 20px;height: 20px;}
</style>
@endpush

@push('custom-scripts')

<script src="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">

        $('#myTable').DataTable();

        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });

</script>

@endpush