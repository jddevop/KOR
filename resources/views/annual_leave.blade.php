@extends('layouts.app')
@section('title', 'Annual Leave')
@section('content')

	<div class="row">				  
		<div class="col-12">
			<div class="alm-top">
				<h3>Annual Leave Management</h3>
				<h6>As an employee of KÓR Project Management, you earn 8% annual leave on all hours worked. This page shows your annual leave earned and taken. You must book your annual leave in order to receive payment for the accumulated amount. The hours worked field is approximate and may change based on the approved hours.</h6>
			</div>
			<div class="alm-wh-box">
				<h5>Aprox. Eligible Leave Hours</h5>
				<h6><?php echo $start_date; ?> - <?php echo $end_date; ?></h6>
				<h4><?php echo $eligible_leave_hours; ?>h x 8%</h4>
			</div>
			<div class="alm-wh-box">
				<h5>Eligible (8%)</h5>
				<h4><?php echo $eligible=get_time_percentage($eligible_leave_hours,8); ?>h</h4>
			</div>	
			<div class="alm-table">
				<h5>Concluded Events</h5>
				<div class="table-responsive">
					<table class="ce-table">
						<tr>
							<th>Date</th>
							<th>Hours Worked</th>
							<th>Annual Leave (8%)</th>
							<th>Status</th>
						</tr>
						<?php foreach($annual_data as $key=>$val){ ?>
						<tr>
							<td><?php echo date("d M Y", strtotime($val['date'])); ?></td>
							<td><?php echo $val['hours_worked']; ?>h</td>
							<td><?php echo $val['annual_leave']; ?>h</td>
							<?php if($val['status']==0){ ?>
							    <td class="cereq">Requested</td>
						   <?php }else if($val['status']==1){
						   ?>
						        <td class="cepaid">Paid</td>
						   <?php
						   }else if($val['status']==1){
						   ?>
						        <td class="cenr">Rejected</td>
						   <?php
						   }?>
						</tr>
					  <?php }?>
																						
					</table>
				</div>
			</div>				
		</div>
	</div>
	<div class="d-grid mb-3">
		<a href="javascript:void(0)" class="blue-btn-link" onclick="book_annual_leave()">Book Annual Leave & Holiday Pay</a>
	</div>			
<div class="loadingClass" id="showload">
    <img src="{{ asset('asset/images/loader.gif') }}" alt="loader" />
</div>
@endsection
@push('custom-scripts')
<script>
function book_annual_leave(){
    var eligible_leave_hours="<?php echo $eligible_leave_hours; ?>";
    var eligible="<?php echo $eligible; ?>";
    if (eligible_leave_hours && eligible_leave_hours !== '00:00') {
       $.ajax({
            url: "{{ route('book_annual_leave') }}",
            method: 'post',
            data: {
                'eligible_leave_hours': eligible_leave_hours,
                'eligible':eligible
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
                   window.location.href = "{{ route('request_in_review') }}";
                } else {
                    alert(result.message);
                }
            }
        }); 
    } else {
        alert("No eligible leave hours");
    }
}
</script>
@endpush
		