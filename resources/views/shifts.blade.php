@extends('layouts.app')
@section('title', 'Shift')
@section('content')
<div class="row">
<div class="col-12">
	<h4 class="mb-3">Shift List & History</h4>
	<div class="d-flex">
		<div class="scrolling-wrapper">
			<div class="btn-group" role="group">
				<input type="radio" class="btn-check" name="status" id="all" autocomplete="off" checked value="all" onclick="get_event()">
				<label class="" for="all">All</label>

				<input type="radio" class="btn-check" name="status" id="ongoing" autocomplete="off" value="6" onclick="get_event()">
				<label class="" for="ongoing">Ongoing</label>

				<input type="radio" class="btn-check" name="status" id="concluded" autocomplete="off" value="7" onclick="get_event()">
				<label class="" for="concluded">Concluded</label>

				<input type="radio" class="btn-check" name="status" id="confirmed" autocomplete="off" value="5" onclick="get_event()">
				<label class="" for="confirmed">Confirmed</label>

				<input type="radio" class="btn-check" name="status" id="missed" autocomplete="off" value="2" onclick="get_event()">
				<label class="" for="missed">Missed</label>									
			</div>
		</div>
		<div class="dropdown sortbox">
			<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
				Sorting <img src="{{ asset('asset/images/sort.png') }}" class="img-fluid">
			</button>
			<ul class="dropdown-menu">
				<li><a class="dropdown-item" href="javascript:void(0)" data-sort="newest" onclick="get_sort('newest')">Newest First </a></li>
				<li><a class="dropdown-item" href="javascript:void(0)" data-sort="oldest" onclick="get_sort('oldest')">Oldest First</a></li>
				<li><a class="dropdown-item" href="javascript:void(0)" data-sort="starttime" onclick="get_sort('start')">Start Time </a></li>
				<li><a class="dropdown-item" href="javascript:void(0)" data-sort="endtime" onclick="get_sort('end')">End Time</a></li>									
				<li><a class="dropdown-item" href="javascript:void(0)" data-sort="nameasc" onclick="get_sort('asc')">Name A-Z</a></li>
				<li><a class="dropdown-item" href="javascript:void(0)" data-sort="namedesc" onclick="get_sort('desc')">Name Z-A</a></li>
			</ul>
		</div>
	</div>
</div>				
<div class="col-12" id="show_event">
	
</div>
</div>
<div class="loadingClass" id="showload">
    <img src="{{ asset('asset/images/loader.gif') }}" alt="loader" />
</div>
@endsection
@push('custom-scripts')
<script>
$(document).ready(function () {
    get_event_shift_by_filter('all');
});
function get_event_shift_by_filter(type) {
    $.ajax({
        url: "{{ route('get_event_shift_by_filter') }}",
        method: 'post',
        data: {
            'type': type
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        beforeSend: function() {
            $('#showload').show();
        },
        success: function(result) {
            $('#showload').hide();
            if (result.status == 1) {
                $('#show_event').html(result.html_event_data);
            } else {
                
            }
        }
    });
}
function get_event(){
    var status = $('input[name="status"]:checked').val();
    get_event_shift_by_filter(status);
}
function get_sort(sort){
     var status = $('input[name="status"]:checked').val();
    $.ajax({
        url: "{{ route('get_event_shift_by_filter') }}",
        method: 'post',
        data: {
            'type': status,
            'sort':sort
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        beforeSend: function() {
            $('#showload').show();
        },
        success: function(result) {
            $('#showload').hide();
            if (result.status == 1) {
                $('#show_event').html(result.html_event_data);
            } else {
                
            }
        }
    });
}
</script>
@endpush

		