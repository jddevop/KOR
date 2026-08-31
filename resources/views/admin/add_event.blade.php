@extends('admin.layouts.main')
@section('title')
    Add Event 
@endsection
@section('content')
           <div class="container-fluid">
	
	        <div class="row">
        		<div class="col-md-12">
        		    <div class="panel panel-info">
                            <div class="panel-heading"> {{ $mode }} Event</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
        			            @include('admin.layouts.partials.flash')
                            
                            <form class="form-horizontal" method="post" action="{{ (Request::route()->getName() == 'event.edit') ? route('event.update', (isset($data->id)) ? $data->id : '') : route('event.store') }}" enctype="multipart/form-data">
                                @if (Request::route()->getName() == 'event.edit')
									@method('PATCH')
								@endif
								@csrf
								<div class="form-body">
								<!-- Block 1: Event Info -->
                                <h3 class="box-title m-t-20">Event Info</h3>
                                <hr>
							    <div class="row">
							        <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Name <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ old('name') != '' ? old('name') : (isset($data->name) ? $data->name : '') }}">
        											@error('name')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Start Date <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="date" class="form-control" name="start_date" id="start_date" placeholder="Enter Start Date" value="{{ old('start_date') != '' ? old('start_date') : (isset($data->start_date) ? $data->start_date : '') }}">
        											@error('start_date')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">End Date <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="date" class="form-control" name="end_date" id="end_date" placeholder="Enter End Date" value="{{ old('end_date') != '' ? old('end_date') : (isset($data->end_date) ? $data->end_date : '') }}">
        											@error('end_date')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
    								    <div class="form-group">
                                                    <label class="col-md-12">Image <?php if (Request::route()->getName() == 'event.edit'){ }else{ ?><span class="text-danger">*</span><?php }?></label>
                                                    <div class="col-md-12">
                                                        <div class="row">
        										   <div class="col-md-10 col-xs-12">
        										   
        										<input type="file" class="form-control" name="image" id="image" title="Browse file"/>
        									</div>
        									<div class="col-md-2 col-xs-12">
        											@if(isset($data->image))
        												@if($data->image!='')
        												   <img src="{{ asset('upload/event/'.$data->image) }}" width="50">
        												@endif
        											@endif  
        									</div>
        								</div>
        											@error('image')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Short Description <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                    
                                                <textarea name="short_description" id="short_description" class="form-control">{{ old('short_description') != '' ? old('short_description') : (isset($data->short_description) ? $data->short_description : '') }}</textarea>
        											@error('short_description')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                   </div> 
                                    <div class="row"> 
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
    								    <div class="form-group">
                                            <label class="col-md-12">What you will be doing <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <textarea name="what_you_will_be_doing" id="what_you_will_be_doing" class="form-control">{{ old('what_you_will_be_doing') != '' ? old('what_you_will_be_doing') : (isset($data->what_you_will_be_doing) ? $data->what_you_will_be_doing : '') }}</textarea>
        											@error('what_you_will_be_doing')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
    								    <div class="form-group">
                                            <label class="col-md-12">General Information <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <textarea name="general_information" id="general_information" class="form-control">{{ old('general_information') != '' ? old('general_information') : (isset($data->general_information) ? $data->general_information : '') }}</textarea>
        											@error('general_information')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                 <h3 class="box-title m-t-40">Location</h3>
                                <hr>  
                                 <div class="row"> 
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Address <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" value="{{ old('address') != '' ? old('address') : (isset($data->address) ? $data->address : '') }}">
                                                <input type="hidden" id="lat" name="lat" value="{{ old('lat') != '' ? old('lat') : (isset($data->lat) ? $data->lat : '') }}">
                                                <input type="hidden" id="long" name="long" value="{{ old('long') != '' ? old('long') : (isset($data->long) ? $data->long : '') }}">
        											@error('address')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        											 @error('address1')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Meeting Point Address <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="meeting_point_address" id="meeting_point_address" placeholder="Enter Address" value="{{ old('meeting_point_address') != '' ? old('meeting_point_address') : (isset($data->meeting_point_address) ? $data->meeting_point_address : '') }}">
                                                <input type="hidden" id="meeting_point_lat" name="meeting_point_lat" value="{{ old('meeting_point_lat') != '' ? old('meeting_point_lat') : (isset($data->meeting_point_lat) ? $data->meeting_point_lat : '') }}">
                                                <input type="hidden" id="meeting_point_long" name="meeting_point_long" value="{{ old('meeting_point_long') != '' ? old('meeting_point_long') : (isset($data->meeting_point_long) ? $data->meeting_point_long : '') }}">
        											@error('meeting_point_address')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        											 @error('meeting_point_address1')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Short Text Meeting Point Address <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                    
                                                <textarea name="short_text_meeting_point_address" id="short_text_meeting_point_address" class="form-control">{{ old('short_text_meeting_point_address') != '' ? old('short_text_meeting_point_address') : (isset($data->short_text_meeting_point_address) ? $data->short_text_meeting_point_address : '') }}</textarea>
        											@error('short_text_meeting_point_address')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                 
                                 
                                 
                                 </div>
                                
                                
                                
                                 <h3 class="box-title m-t-40">Staff Requirements</h3>
                                <hr>  
                                 <div class="row"> 
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Role <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="role" id="role" placeholder="Enter Role" value="{{ old('role') != '' ? old('role') : (isset($data->role) ? $data->role : '') }}">
        											@error('role')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Total Staff Required <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control priceOnly" name="total_staff_required" id="total_staff_required" placeholder="Enter Total Staff Required" value="{{ old('total_staff_required') != '' ? old('total_staff_required') : (isset($data->total_staff_required) ? $data->total_staff_required : '') }}">
        											@error('total_staff_required')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Payment Rate <span class="text-danger">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control priceOnly" name="payment_rate" id="payment_rate" placeholder="Enter Payment Rate" value="{{ old('payment_rate') != '' ? old('payment_rate') : (isset($data->payment_rate) ? $data->payment_rate : '') }}">
    											@error('payment_rate')
    											  <div id="error_message" class="text-danger">{{ $message }}</div>
    											 @enderror
    									</div>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">WhatsApp Group Link <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="whatsapp_group_link" id="whatsapp_group_link" placeholder="Enter WhatsApp Group Link" value="{{ old('whatsapp_group_link') != '' ? old('whatsapp_group_link') : (isset($data->whatsapp_group_link) ? $data->whatsapp_group_link : '') }}">
        											@error('whatsapp_group_link')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                    <label class="col-md-12">Transport</label>
                                                    <div class="col-md-12">
                                                        <div class="radio-list">
                                                            
                                                            <label class="radio-inline p-0">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="transport" id="transport1" value="1"
                                                                        {{ (old('transport') == 1 || (isset($data->transport) && $data->transport == 1)) ? 'checked' : 'checked' }}>
                                                                    <label for="transport1">Provided</label>
                                                                </div>
                                                            </label>
                                                
                                                            <label class="radio-inline">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="transport" id="transport2" value="0"
                                                                        {{ (old('transport') == "0" || (isset($data->transport) && $data->transport == 0)) ? 'checked' : '' }}>
                                                                    <label for="transport2">Not Provided</label>
                                                                </div>
                                                            </label>
                                                
                                                        </div>
                                                    </div>
</div>
                                                </div>
                                    
                                    
                                    
                                    
                                  <?php /*  <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Shift Start Time <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="time" class="form-control" name="shift_start_time" id="shift_start_time" placeholder="Enter Shift Start Time" value="{{ old('shift_start_time') != '' ? old('shift_start_time') : (isset($data->shift_start_time) ? $data->shift_start_time : '') }}">
        											@error('shift_start_time')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Shift End Time <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                                                <input type="time" class="form-control" name="shift_end_time" id="shift_end_time" placeholder="Enter Shift End Time" value="{{ old('shift_end_time') != '' ? old('shift_end_time') : (isset($data->shift_end_time) ? $data->shift_end_time : '') }}">
        											@error('shift_end_time')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
    								    <div class="form-group">
                                                    <label class="col-md-12">Company Logo <?php if (Request::route()->getName() == 'event.edit'){ }else{ ?><span class="text-danger">*</span><?php }?></label>
                                                    <div class="col-md-12">
                                                        <div class="row">
        										   <div class="col-md-10 col-xs-12">
        										  
        										<input type="file" class="form-control" name="company_logo" id="company_logo" title="Browse file"/>
        									</div>
        									<div class="col-md-2 col-xs-12">
        											@if(isset($data->company_logo))
        												@if($data->company_logo!='')
        												   <img src="{{ asset('upload/event/'.$data->company_logo) }}" width="50">
        												@endif
        											@endif  
        									</div>
        								</div>
        											@error('company_logo')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-3">
    								    <div class="form-group">
                                            <label class="col-md-12">Short Text Address <span class="text-danger">*</span></label>
                                            <div class="col-md-12">
                    
                                                <textarea name="short_text_address" id="short_text_address" class="form-control">{{ old('short_text_address') != '' ? old('short_text_address') : (isset($data->short_text_address) ? $data->short_text_address : '') }}</textarea>
        											@error('short_text_address')
        											  <div id="error_message" class="text-danger">{{ $message }}</div>
        											 @enderror
        									</div>
                                        </div>
                                    </div>*/?>
                                    
                                    
                                    
                                    
                                    
                                    
                                     
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
            $('#what_you_will_be_doing').trumbowyg({
                btns: [
                    ['formatting'],
                    ['bold', 'italic', 'underline'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight','viewHTML']
                ]
            });
            $('#general_information').trumbowyg({
                btns: [
                    ['formatting'],
                    ['bold', 'italic', 'underline'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight','viewHTML']
                ]
            });
	});
</script>
<script type="text/javascript">
/*$(document).on("keypress keyup keydown",".priceOnly",function (e) {
 //if the letter is not digit then display error and don't type anything
	alert(e.which )
 if (e.which != 110 &&e.which != 46 && e.which != 9 && e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 96 || e.which > 105)) {
	//$("#errmsg").html("Digits Only").show().fadeOut("slow");
	return false;
}
});*/
$(document).on("input", ".priceOnly", function () {
    this.value = this.value.replace(/[^0-9.]/g, '')   // only number + dot
                           .replace(/(\..*?)\..*/g, '$1'); // only one dot
});
</script>
<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&libraries=places"></script>

<script>
    function initAutocomplete() {
        const input = document.getElementById('address');

        if (!input) {
            console.error("Address input not found");
            return;
        }

        const autocomplete = new google.maps.places.Autocomplete(input);

        // When user selects address
        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();

            if (!place.geometry) {
                console.error("No details available for input");
                return;
            }

            // Get latitude & longitude
            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();

            // Set hidden inputs
            document.getElementById('lat').value = lat;
            document.getElementById('long').value = lng;
        });
        
        
         const input1 = document.getElementById('meeting_point_address');

        if (!input1) {
            console.error("Address input not found");
            return;
        }

        const autocomplete1 = new google.maps.places.Autocomplete(input1);

        // When user selects address
        autocomplete1.addListener('place_changed', function () {
            const place = autocomplete1.getPlace();

            if (!place.geometry) {
                console.error("No details available for input");
                return;
            }

            // Get latitude & longitude
            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();

            // Set hidden inputs
            document.getElementById('meeting_point_lat').value = lat;
            document.getElementById('meeting_point_long').value = lng;
        });
        
    }

    // Load after page load
    window.addEventListener('load', initAutocomplete);
</script>
@endpush