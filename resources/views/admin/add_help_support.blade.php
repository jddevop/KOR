@extends('admin.layouts.main')
@section('title')
    Add Help & Support 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-md-6 col-md-offset-3">
        		    @include('admin.layouts.partials.flash')
        		    <div class="panel panel-info">
                            <div class="panel-heading"> {{ $mode }} Help & Support</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                            
                            <form class="form-horizontal" method="post" action="{{ (Request::route()->getName() == 'help_support.edit') ? route('help_support.update', (isset($data->id)) ? $data->id : '') : route('help_support.store') }}" enctype="multipart/form-data">
                                @if (Request::route()->getName() == 'help_support.edit')
									@method('PATCH')
								@endif
								@csrf
								<div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-12">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ old('name') != '' ? old('name') : (isset($data->name) ? $data->name : '') }}">
											@error('name')
											  <div id="error_message" class="text-danger">{{ $message }}</div>
											 @enderror
									</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-12">Description <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
            
                                        <textarea name="description" id="description" class="form-control">{{ old('description') != '' ? old('description') : (isset($data->description) ? $data->description : '') }}</textarea>
											@error('description')
											  <div id="error_message" class="text-danger">{{ $message }}</div>
											 @enderror
									</div>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg/dist/ui/trumbowyg.min.css">
@endpush
@push('custom-scripts')
 <script src="https://cdn.jsdelivr.net/npm/trumbowyg/dist/trumbowyg.min.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
            // Initialize Trumbowyg editor with custom options
            $('#description').trumbowyg({
                btns: [
                    ['formatting'],
                    ['bold', 'italic', 'underline'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight','viewHTML']
                ]
            });
	});
</script>
@endpush