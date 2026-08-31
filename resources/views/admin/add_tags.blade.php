@extends('admin.layouts.main')
@section('title')
    Add City 
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        	@include('admin.layouts.partials.flash')
        	<div class="panel panel-info">
                <div class="panel-heading"> {{ $mode }} Tag </div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" action="{{ (Request::route()->getName() == 'tags.edit') ? route('tags.update', (isset($data->id)) ? $data->id : '') : route('tags.store') }}" enctype="multipart/form-data">
                                @if (Request::route()->getName() == 'tags.edit')
									@method('PATCH')
								@endif
								@csrf
								<?php $a=0;
								    if (Request::route()->getName() == 'tags.edit')
								    {
								        if($data->id <= 12)
								        {
								            $a=1;
								        }
								    }
								?>
								
                                <div class="form-group">
                                    <label class="col-md-12">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ old('name') != '' ? old('name') : (isset($data->name) ? $data->name : '') }}" <?php if($a==1){?> disabled <?php } ?>>
                                        @error('name')
											  <div id="error_message" class="text-danger">{{ $message }}</div>
											 @enderror
                                    </div>
                                </div> 
                                
                                <div class="form-group">
                                    <label class="col-md-12"> Color <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="complex-colorpicker form-control" name="color" id="color" placeholder="Enter Color" value="{{ old('color') != '' ? old('color') : (isset($data->color) ? $data->color : '') }}" />
                                        @error('color')
											  <div id="error_message" class="text-danger">{{ $message }}</div>
											 @enderror
                                    </div>
                                </div>                                 
                                
                                <div class="form-group m-b-0">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10 pull-right">Submit</button>
                                </div>                              
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection

@push('custom-style')
<link href="{{ asset('asset/admin/plugins/components/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('asset/admin/plugins/components/jquery-asColorPicker-master/css/asColorPicker.css') }}" rel="stylesheet" type="text/css" />
<style>
    .asColorPicker-dropdown {
        max-width: 260px;
    }    
    .asColorPicker-trigger {
        position: absolute;
        top: 0;
        right: -35px;
        height: 38px;
        width: 37px;
        border: 0;
    } 
    .asColorPicker-clear {
        top: 7px;
        right: 16px;
    }    
</style>
@endpush

@push('custom-scripts')
    <script src="{{ asset('asset/admin/plugins/components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/jquery-asColorPicker-master/libs/jquery-asColor.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/jquery-asColorPicker-master/libs/jquery-asGradient.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/components/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js') }}"></script>
<script>
    $(".complex-colorpicker").asColorPicker({
        mode: 'complex'
    });    
</script>    
@endpush



    

    