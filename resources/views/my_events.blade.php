@extends('layouts.app')
@section('title', 'Events')
@section('content')
<div class="row">
<div class="col-12">
	<h4 class="mb-3">My Events</h4>
	<div class="scrolling-wrapper">
		<div class="btn-group" role="group">
			
			<input type="radio" class="btn-check" name="status" id="all" autocomplete="off" checked  value="all" onclick="get_event()">
			<label class="" for="all">All</label>

			<input type="radio" class="btn-check" name="status" id="invited" autocomplete="off"  value="1" onclick="get_event()">
			<label class="" for="invited">Invited</label>
			
			<input type="radio" class="btn-check" name="status" id="applied" autocomplete="off"  value="3" onclick="get_event()">
			<label class="" for="applied">Applied</label>

			<input type="radio" class="btn-check" name="status" id="confirmed" autocomplete="off"  value="5" onclick="get_event()">
			<label class="" for="confirmed">Confirmed</label>
			
			<input type="radio" class="btn-check" name="status" id="ongoing" autocomplete="off"  value="6" onclick="get_event()">
			<label class="" for="ongoing">Ongoing</label>

			<input type="radio" class="btn-check" name="status" id="completed" autocomplete="off" value="7" onclick="get_event()">
			<label class="" for="completed">Completed</label>
			
			<input type="radio" class="btn-check" name="status" id="rejected" autocomplete="off" value="4" onclick="get_event()">
			<label class="" for="rejected">Rejected</label>
										
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
    get_event_by_filter('all');
});
function get_event_by_filter(type) {
    $.ajax({
        url: "{{ route('get_event_by_filter') }}",
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
    get_event_by_filter(status);
}
</script>

@endpush