@extends('admin.layouts.main')
@section('title')
    Support Number 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-md-6 col-md-offset-3">
        		    <div class="panel panel-info">
                            <div class="panel-heading"> Support Number</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
        			
        			    @include('admin.layouts.partials.flash')
                            <form class="form-horizontal" method="post" action="{{ route('support_number.store') }}" enctype="multipart/form-data">
                                @csrf
							    <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-12">Support Number <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="support_number" id="support_number" placeholder="Enter Support Number" value="{{ old('support_number') != '' ? old('support_number') : (isset($data->support_number) ? $data->support_number : '') }}">
											@error('support_number')
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