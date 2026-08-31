@extends('layouts.app')
@section('title', 'Shift')
@section('content')


<div class="row">
	<div class="col-12">
		<div class="shift-dark-info">
			<h3><?php echo $data_event['data_event']; ?></h3>
			<p><?php echo date('H:i',strtotime($data_event['shift_start_time'])) ?> - <?php echo date('H:i',strtotime($data_event['shift_end_time'])) ?> • Event Crew</p>
			
    		    <span class="completed">Concluded</span>

		</div>
	</div>
</div> 
<div class="row">
	<div class="col-6">
		<div class="shift-info">
			<h5>Role</h5>
			<h4><?php echo $data_event['role']; ?></h4>
		</div>
	</div>
	<div class="col-6">
		<div class="shift-info">
			<h5>Total Hours</h5>
			<h4 id="show_total_hours">00:00</h4>
		</div>
	</div>							
</div>
<div class="row">
	<div class="col-12">
		<div class="shift-timeline">
			<p class="st-title">Shift Timeline</p>
        <div id="show_shift">
			
		</div>
		</div>
	</div>
</div>

<!-- Ongoing End -->	

</div>

</div>

<div class="loadingClass" id="showload">
    <img src="{{ asset('asset/images/loader.gif') }}" alt="loader" />
</div>
@endsection
@push('custom-style')
<style>
.hidden { display: none; }
</style>
@endpush
@push('custom-scripts')
<script>
$(document).ready(function () {
    get_event_shift_detail_by_filter();
});
function get_event_shift_detail_by_filter(){
    var event_id="<?php echo $data_event['id']; ?>";
   $.ajax({
        url: "{{ route('get_event_shift_detail_by_filter') }}",
        method: 'post',
        data: {
            'event_id': event_id
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
                $('#show_shift').html(result.html_shift_data);
                $('#show_total_hours').html(result.total_hours);
                
            } else {
                
            }
        }
    }); 
}
</script>
@endpush

		