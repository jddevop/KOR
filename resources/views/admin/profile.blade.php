@extends('admin.layouts.main')
@section('title')
    Profile 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-md-6 col-md-offset-3">
        		    <div class="panel panel-info">
                            <div class="panel-heading"> Profile</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
        			
        			    @include('admin.layouts.partials.flash')
                            
                            
                            <form class="form-horizontal" method="post" action="{{ route('admin.profile') }}" enctype="multipart/form-data">
                                @csrf
							    {{ method_field('patch') }}
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
                                    <label class="col-md-12">Email <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ old('email') != '' ? old('email') : (isset($data->email) ? $data->email : '') }}">
										   @error('email')
										  	<div id="error_message" class="text-danger">{{ $message }}</div>
										 	@enderror
									</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-12">Mobile No <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter Mobile No" value="{{ old('mobile_no') != '' ? old('mobile_no') : (isset($data->mobile_no) ? $data->mobile_no : '') }}">
										   @error('mobile_no')
										  	<div id="error_message" class="text-danger">{{ $message }}</div>
										 	@enderror
									</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-12">Image </label>
                                    <div class="col-md-12">
                                        <div class="row">
											   <div class="col-md-6 col-xs-12">
											<input type="file" class="form-control" name="image" id="image" title="Browse file"/>
										</div>
												<div class="col-md-2 col-xs-12">
												@if(isset($data->image))
													@if($data->image!='')
														
													   <img src="{{ asset('upload/admin/'.$data->image) }}" width="40">
												
													@else
														<img src="{{ asset('asset/admin/plugins/images/user.jpg') }}" width="40">
													@endif
												@else
												   <img src="{{ asset('asset/admin/plugins/images/user.jpg') }}" width="40">
												@endif  
											
										</div>
									</div>
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