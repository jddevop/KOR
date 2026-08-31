@extends('admin.layouts.main')
@section('title')
    Change Password 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-md-6 col-md-offset-3">
        		    <div class="panel panel-info">
                            <div class="panel-heading"> Change Password</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
        			
        			    @include('admin.layouts.partials.flash')
                           
                            
                            <form class="form-horizontal" method="post" action="{{ route('admin.change_password_update') }}" enctype="multipart/form-data">
                                @csrf
							    {{ method_field('patch') }}
							    <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-12">Old Password <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="opassword" id="opassword" placeholder="Old Password">
											@error('opassword')
											  <div id="error_message" class="text-danger">{{ $message }}</div>
											 @enderror
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">New Password <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="npassword" id="npassword" placeholder="New Password">
										   @error('npassword')
										  	<div id="error_message" class="text-danger">{{ $message }}</div>
										 	@enderror
									</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-12">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm Password">
										   @error('cpassword')
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