@extends('admin.layouts.main')
@section('title')
    Terms of Employment 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-md-6 col-md-offset-3">
        		    <div class="panel panel-info">
                            <div class="panel-heading"> Terms of Employment</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
        			
        			    @include('admin.layouts.partials.flash')
                            <form class="form-horizontal" method="post" action="{{ route('terms_of_employment.store') }}" enctype="multipart/form-data">
                                <input type="hidden" name="status" id="status" value="1">
                                @csrf
							    <div class="form-body">
                                
                                <div class="form-group">
                                    <label class="col-md-12">Docs </label>
                                    <div class="col-md-12">
                                        <div class="row">
											   <div class="col-md-6 col-xs-12">
											<input type="file" class="form-control" name="doc" id="doc" title="Browse file" accept="application/pdf"/>
										</div>
												<div class="col-md-2 col-xs-12">
												 @if(isset($data->doc) && $data->doc != '')
                    
                                                    <a href="{{ asset('upload/terms_of_employment/'.$data->doc) }}" 
                                                       target="_blank" 
                                                       class="btn btn-xs btn-primary btn_emp">
                                                        View PDF
                                                    </a>
                                
                                                @endif    
											
										</div>
										
									</div>
									@error('doc')
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