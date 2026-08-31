@extends('admin.layouts.main')
@section('title')
    Employer 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-md-6 col-md-offset-3">
        		    <div class="panel panel-info">
                            <div class="panel-heading"> Employer</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
        			
        			    @include('admin.layouts.partials.flash')
                            <form class="form-horizontal" method="post" action="{{ route('employer.store') }}" enctype="multipart/form-data">
                                @csrf
							    <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-12">Employer Name <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="employer_name" id="employer_name" placeholder="Enter Employer Name" value="{{ old('employer_name') != '' ? old('employer_name') : (isset($data->employer_name) ? $data->employer_name : '') }}">
											@error('employer_name')
    										  <div id="error_message" class="text-danger">{{ $message }}</div>
    										 @enderror
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Employer Number <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="employer_number" id="employer_number" placeholder="Enter Employer Number" value="{{ old('employer_number') != '' ? old('employer_number') : (isset($data->employer_number) ? $data->employer_number : '') }}">
										   @error('employer_number')
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
                                    <label class="col-md-12">Contact Number <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Enter Contact Number" value="{{ old('contact_number') != '' ? old('contact_number') : (isset($data->contact_number) ? $data->contact_number : '') }}">
										   @error('contact_number')
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
														
													   <img src="{{ asset('upload/employer/'.$data->image) }}" width="40">
												
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