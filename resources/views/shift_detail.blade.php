@extends('layouts.app')
@section('title', 'Shift')
@section('content')

<!-- Ongoing Start -->
<div class="row">
	<div class="col-12">
	    <p class="fw-bold text-center">Check your shift time in the event page.</p>
	 </div>
</div>
<div class="row">
	<div class="col-12">
		<div class="toggleclock">
			<div class="clockin " id="clockInBtn" data-bs-toggle="modal" data-bs-target="#noteModal" style="pointer-events: none; opacity: 0.5;">
				<h2>clock in</h2>
				<p>Current Time : <span id="live-clock">00 : 00 : 00</span></p>
			</div>
			<div class="clockout hidden" id="clockOutBtn" data-bs-toggle="modal" data-bs-target="#noteModalout">
				<h2>clock out</h2>
				<p>Total Time : <span id="running-duration">00 : 00 : 00</span></p>
			</div>						
		</div>
	</div>
</div> 
<div class="row">
	<div class="col-12">
		<div class="shift-dark-info">
			<h3><?php echo $data_event['data_event']; ?></h3>
			<?php /*<p><?php echo date('h:i A',strtotime($shift_start_time)) ?> - <?php echo date('h:i A',strtotime($shift_end_time)) ?> • <?php echo $role; ?></p>*/?>
			<?php foreach($arr_time as $key=>$val){ ?>
			    <p><?php echo $val['start_time']; ?> - <?php echo $val['end_time']; ?> • <?php echo $val['name']; ?></p>
			<?php }?>
			<?php $get_status=get_event_status($data_event['id']); ?>
    	    <?php if($get_status==0){ ?>
    		<span class="open">open</span>
    		<?php }else if($get_status==1){
    		?>
    		    <span class="invited">Invited</span>
    		<?php
    		}else if($get_status==2){
    		?>
    		    <span class="missed">Missed</span>
    		<?php
    		}else if($get_status==3){
    		?>
    		    <span class="open">Applied</span>
    		<?php
    		}else if($get_status==4){
    		?>
    		    <span class="missed">Rejected</span>
    		<?php
    		}else if($get_status==5){
    		?>
    		    <span class="confirmed">Confirmed</span>
    		<?php
    		}else if($get_status==6){
    		?>
    		    <span class="ongoing">Ongoing</span>
    		<?php
    		}else if($get_status==7){
    		?>
    		    <span class="completed">Completed</span>
    		<?php
    		}?>
			
		</div>
	</div>
</div> 
<div class="row">
	<div class="col-6">
		<div class="shift-info">
			<h5>Role </h5>
			<h4><?php echo $role; ?></h4>
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
<?php /*<div class="row">		
	<div class="col-6">
		<div class="shift-info text-center">
			<h5>Pending</h5>
			<h4>Submitted</h4>
		</div>
	</div>
	<div class="col-6">
		<div class="shift-info text-center">
			<h5>Not Submitted</h5>
			<h4>Processed</h4>
		</div>
	</div>				
</div>	*/?>	
<!-- Ongoing End -->	

</div>
<div class="modal fade" id="noteModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="noteModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-body">
			<div class="und-top">
				<div >
    <h2 class="mb-0">Add Note</h2>
   
</div>
				<a href="javascript:void(0)" class="" data-bs-dismiss="modal">
					<img src="{{ asset('asset/images/close-circle.png') }}" class="img-fluid">
				</a>
			</div>
			<form id="addnoteform">
				<div class="mb-3">
					<label class="form-label">Explanatory Note </label>
					<input type="text" class="form-control " placeholder="Enter explanatory note" name="clock_in_explanatory_note" id="clock_in_explanatory_note">
					<p class="text-danger err_msg" id="msg_clock_in_explanatory_note"></p>
				</div>	
				
				<div class="d-grid">
					<button type="button" class="btn btn-primary blue-btn" onclick="clock_in()">Submit</button>
				</div>
			</form>
										
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="noteModalout" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="noteModaloutLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-body">
			<div class="und-top">
				<div>
					<h2 class="mb-0">Add Note</h2>
				</div>
				<a href="javascript:void(0)" class="" data-bs-dismiss="modal">
					<img src="{{ asset('asset/images/close-circle.png') }}" class="img-fluid">
				</a>
			</div>
			<form id="addnoteform">
				<div class="mb-3">
					<label class="form-label">Explanatory Note </label>
					<input type="text" class="form-control " placeholder="Enter explanatory note" name="clock_out_explanatory_note" id="clock_out_explanatory_note">
					<p class="text-danger err_msg" id="msg_clock_out_explanatory_note"></p>
				</div>	
				
				<div class="d-grid">
					<button type="button" class="btn btn-primary blue-btn" onclick="clock_out()">Submit</button>
				</div>
			</form>
										
		</div>
	</div>
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
                if(result.shift_check==1){
                    //$('.toggleclock').html('<div class="alert alert-warning text-center">You have already completed today’s shift.</div>');
                }
            } else {
                
            }
        }
    }); 
}
</script>
<script>
	$(document).ready(function(){
		$("#addnoteform").submit(function(e){
			e.preventDefault(); 			
			bootstrap.Modal.getInstance(document.getElementById('noteModal')).hide();
			this.reset();
			$(".clockin").toggle(); 
			$(".clockout").toggle(); 
		});
	});
</script>
<script>
    function updateClock() {
        const now = new Date();
        // Time format (HH : MM : SS)
        let hours = String(now.getHours()).padStart(2, '0');
        let minutes = String(now.getMinutes()).padStart(2, '0');
        let seconds = String(now.getSeconds()).padStart(2, '0');
        
        const timeString = `${hours} : ${minutes} : ${seconds}`;
        
        document.getElementById('live-clock').textContent = timeString;
    }
    // Function to calculate distance between two coordinates in meters
function getDistance(lat1, lon1, lat2, lon2) {
    const R = 6371e3; // Earth's radius in meters
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // Returns distance in meters
}
// 2. Function to validate both location and shift time
function checkLocationAndShift() {
    const clockInBtn = document.getElementById('clockInBtn');
    const msgLabel = document.getElementById('shift-status-msg');
    
    // Retrieve Event Location from PHP (Ensure these keys exist in your $data_event array)
    /*const eventLat = parseFloat("<?php echo $data_event['lat'] ?? 0; ?>");
    const eventLng = parseFloat("<?php echo $data_event['long'] ?? 0; ?>");*/

    /*if (!navigator.geolocation) {
        return;
    }*/
        /*navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
    
            const distance = getDistance(userLat, userLng, eventLat, eventLng);
        console.log(userLat+' fgfg'+userLng);*/
            
            /*const now = new Date();
            const shiftStart = new Date("<?php echo date('Y-m-d H:i:s', strtotime($shift_start_time)); ?>");
            const shiftEnd = new Date("<?php echo date('Y-m-d H:i:s', strtotime($shift_end_time)); ?>");
           console.log(shiftStart);
            if (now >= shiftStart && now <= shiftEnd) {*/
                // Check if the browser supports Geolocation
                /*if (distance <= 500) {*/
                    clockInBtn.style.pointerEvents = "auto";
                    clockInBtn.style.opacity = "1";
                   
                /*} else {
                    clockInBtn.style.pointerEvents = "none";
                    clockInBtn.style.opacity = "0.5";
                    
                }*/
            /*} else if (now < shiftStart) {
                clockInBtn.style.pointerEvents = "none";
                clockInBtn.style.opacity = "0.5";
               
            } else {
                clockInBtn.style.pointerEvents = "none";
                clockInBtn.style.opacity = "0.5";
                            }*/
        /*}, function(error) {
            
        });*/
    }
    setInterval(function() {
        updateClock(); 
        checkLocationAndShift(); 
    }, 1000);


    let durationInterval;
    
    // 3. Duration Counter (Page Refresh mate)
function startDurationCounter(startTimeStr) {
    if(durationInterval) clearInterval(durationInterval);
    const startTime = new Date(startTimeStr).getTime();
    
    durationInterval = setInterval(() => {
        const now = new Date().getTime();
        const diff = now - startTime;
        if (diff > 0) {
            let hrs = Math.floor(diff / 3600000);
            let mins = Math.floor((diff % 3600000) / 60000);
            let secs = Math.floor((diff % 60000) / 1000);
            $('#running-duration').text(`${hrs.toString().padStart(2, '0')} : ${mins.toString().padStart(2, '0')} : ${secs.toString().padStart(2, '0')}`);
        }
    }, 1000);
}
    
    function clock_in(){
        var event_id="<?php echo $data_event['id']; ?>";
         $(".err_msg").html('');
         
         var error = [];
         var i = 0;
        var clock_in_explanatory_note = $("#clock_in_explanatory_note").val();
        /*if (clock_in_explanatory_note == '') {
            error['msg_clock_in_explanatory_note'] = "Explanatory Note Is Required";
            i++;
        }*/
        if (i < 1) {
            const actionTime = new Date();
            $.ajax({
                    url: "{{ route('clock_in') }}",
                    method: 'post',
                    data: {'event_id':event_id,'clock_in_explanatory_note':clock_in_explanatory_note,'clock_in':actionTime},
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
                            $('#noteModal').modal('hide');
                            localStorage.setItem(`clockInTime${event_id}`, actionTime);
                            startDurationCounter(actionTime);
                            $('#clockInBtn').addClass('hidden');
                            $('#clockOutBtn').removeClass('hidden');
                            $('#show_shift').html(result.html_shift_data);
                            $('#show_total_hours').html(result.total_hours);
                        } else {
                            alert(result.message);
                        }

                    }
                });
        }else{
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
        }
    }
    
    function clock_out(){
        var event_id="<?php echo $data_event['id']; ?>";
         $(".err_msg").html('');
         
         var error = [];
         var i = 0;
        var clock_out_explanatory_note = $("#clock_out_explanatory_note").val();
        /*if (clock_out_explanatory_note == '') {
            error['msg_clock_out_explanatory_note'] = "Explanatory Note Is Required";
            i++;
        }*/
        if (i < 1) {
            const actionTime = new Date();
            $.ajax({
                    url: "{{ route('clock_out') }}",
                    method: 'post',
                    data: {'event_id':event_id,'clock_out_explanatory_note':clock_out_explanatory_note,'clock_out':actionTime},
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
                            $('#noteModalout').modal('hide');
                            localStorage.removeItem(`clockInTime${event_id}`);
                            updateClock();
                            $('#clockInBtn').removeClass('hidden');
                            $('#clockOutBtn').addClass('hidden');
                            $('#show_shift').html(result.html_shift_data);
                            $('#show_total_hours').html(result.total_hours);
                             
                                //$('.toggleclock').html('<div class="alert alert-warning text-center">You have already completed today’s shift.</div>');
                    
                        } else {
                            alert(result.message);
                        }

                    }
                });
        }else{
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
        }
    }
    
    
    $(document).ready(function(){
        var event_id="<?php echo $data_event['id']; ?>";
        const offlineData = localStorage.getItem(`clockInTime${event_id}`);
        if (offlineData) {
            $('#clockInBtn').addClass('hidden');
            $('#clockOutBtn').removeClass('hidden');
            startDurationCounter(localStorage.getItem(`clockInTime${event_id}`));
        }else{
            $('#clockOutBtn').addClass('hidden');
            $('#clockInBtn').removeClass('hidden');
            
            updateClock();
        }
    })
</script>
@endpush

		