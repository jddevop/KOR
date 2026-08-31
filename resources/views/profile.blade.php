@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="row">
	<div class="col-12">
	    @include('layouts.partials.flash')
		<div class="profile-user-info">
			<img src="{{ asset('upload/users/'.$data->profile_picture) }}" class="img-fluid">
			<div>
				<h2><?php echo $data['first_name'].' '.$data['last_name']; ?></h2>
				<p>Event Staff</p>
			</div>
		</div>
	</div>
</div>
<div class="row">		
	<div class="col-6">
		<div class="shift-info text-center">
			<h5>Total Shifts</h5>
			<h4 class=""><?php echo $upcomingshiftCount; ?></h4>
		</div>
	</div>
	<div class="col-6">
		<div class="shift-info text-center">
			<h5>Total Hours</h5>
			<h4 class=""><?php echo get_shift_hours_min(); ?></h4>
		</div>
	</div>				
</div>	
<div class="row">
	<div class="col-12">
		<div class="prof-box">
			<div class="prof-single mb-3 no-border">
				<p class="prof-box-title mb-0">Personal Information</p>
				<a href="{{ route('edit_profile') }}">
					<img src="{{ asset('asset/images/editsq.png') }}" class="img-fluid pfedit">
				</a>
			</div>						
			<div class="prof-single">
				<p class="prof-box-cont">Employee ID</p>
				<p class="prof-box-cont">EMP-<?php echo $data['employee_id']; ?></p>
			</div>
			<div class="prof-single">
				<p class="prof-box-cont">Phone</p>
				<p class="prof-box-cont">+<?php echo $data['phone_text']; ?></p>
			</div>	
			<div class="prof-single">
				<p class="prof-box-cont">Email</p>
				<p class="prof-box-cont"><?php echo $data['email']; ?></p>
			</div>	
			<div class="prof-single no-border">
				<p class="prof-box-cont">Status</p>
				<?php if($data['status']==1){ ?>
				<span class="completed">Active</span>
				<?php }else{
				?>
				<span class="missed">Deactive</span>
				<?php
				}?>
			</div>																								
		</div>						
	</div>
</div>
<?php if($dataemp['employer_name']!=''){ ?>
<div class="row">
	<div class="col-12">
		<div class="prof-box">
			<div class="prof-single mb-3 no-border">
				<p class="prof-box-title mb-0">My Employer</p>

				<img src="<?php echo $dataemp['image']; ?>" class="img-fluid pflogo">

			</div>						
			<div class="prof-single">
				<p class="prof-box-cont">Contact Number</p>
				<p class="prof-box-cont"><?php echo $dataemp['contact_number']; ?>	</p>
			</div>
			<div class="prof-single no-border">
				<p class="prof-box-cont">Email</p>
				<p class="prof-box-cont"><?php echo $dataemp['email']; ?></p>
			</div>	
			<div class="d-flex mt-3 mb-2">
				<label class="form-label mb-0">Revenue Related Information</label>
				<button type="button" class="btn btn-secondary tooltip-btn" data-bs-toggle="tooltip" data-bs-html="true" title="<ul>
<li>
If this is your first registered job in Ireland: Ensure you've completed the 'Starting your first job' process on Revenue. <a href='javascript:void(0)'>Click here</a>
</li>
<li>
Second or Multiple jobs: You don't need to manually register us on Revenue — we'll do it for you. If you are working another job and will be working more shifts with us, you should split your tax credits between employers so that you will not be charged emergency tax. This is simple to do through <a href='javascript:void(0)'>MyGov ID / Revenue online</a>.
</li>  
</ul>">
					<img src="{{ asset('asset/images/tooltip.png') }}" class="img-fluid">
				</button>										
			</div>							
			<div class="prof-single">
				<p class="prof-box-cont">Employer Name</p>
				<p class="prof-box-cont"><?php echo $dataemp['employer_name']; ?></p>
			</div>	
			<div class="prof-single no-border">
				<p class="prof-box-cont">Employer Number</p>
				<p class="prof-box-cont"><?php echo $dataemp['employer_number']; ?></p>
			</div>																								
		</div>						
	</div>
</div>	
<?php }?>
<div class="row">
	<div class="col-12">
		<div class="prof-box">
			<div class="prof-single mb-3 no-border">
				<p class="prof-box-title mb-0">Personal Documents</p>
				
			</div>	
		
		    <?php if($data['nationality']=='Irish'){
		        ?>
            			<div class="prof-single">
        				<p class="prof-box-cont">National ID/Passport</p>
        				<?php 
            			    if($data['national_id']=='')
            			    {
            			?>
        				    <span class="missing">Missing</span>
        				<?php }else{
        				?>
        				     <span class="completed">Completed</span>
        				<?php
        				}?>
        				</div>
        			
        				
		        <?php
		    }else if($data['nationality']=='EU'){
		        ?>
		            <div class="prof-single">
        				<p class="prof-box-cont">National ID/Passport</p>
        				<?php 
            			    if($data['national_id']=='')
            			    {
            			?>
        				    <span class="missing">Missing</span>
        				<?php }else{
        				?>
        				     <span class="completed">Completed</span>
        				<?php
        				}?>
        				</div>
        				
		        <?php
		    }else if($data['nationality']=='Non-EU'){
		        ?>
		            <div class="prof-single">
        				<p class="prof-box-cont">Work permit (Visa/GNIB)</p>
        				<?php 
            			    if($data['permission_to_work1']=='')
            			    {
            			?>
        				    <span class="missing">Missing</span>
        				<?php }else{
        				?>
        				     <span class="completed">Completed</span>
        				<?php
        				}?>
        				</div>
        				
        				
		        <?php
		    }?>
		    <?php if($data['pps_number']!=''){ ?>
		    <div class="prof-single">
			<p class="prof-box-cont">PPS Number</p>
			
			     <span class="completed">Completed</span>
		
			</div>
		    <?php }?>
			<div class="prof-single no-border">
				<p class="prof-box-cont">Terms of Employment</p>
				<span class="completed">Completed</span>
			</div>	
			<a href="{{ route('upload_document') }}" class="uyd-link">Upload your documents <img src="{{ asset('asset/images/blue-arrow.png') }}" class="img-fluid"></a>																							
		</div>						
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="prof-box">
			<div class="prof-single mb-3 no-border">
				<p class="prof-box-title mb-0">Bank Details</p>
				<a href="{{ route('update_bank_detail') }}">
					<img src="{{ asset('asset/images/editsq.png') }}" class="img-fluid pfedit">
				</a>
			</div>						
			<div class="prof-single">
				<p class="prof-box-cont">Account Holder name </p>
				<p class="prof-box-cont maskText"><?php echo $databank['account_holder_name']; ?></p>
			</div>
			<div class="prof-single">
				<p class="prof-box-cont">Home Address </p>
				<p class="prof-box-cont maskText"><?php echo $databank['home_address']; ?></p>
			</div>	
			<div class="prof-single">
				<p class="prof-box-cont">IBAN</p>
				<p class="prof-box-cont maskText"><?php echo $databank['iban']; ?></p>
			</div>	
			<div class="prof-single no-border">
				<p class="prof-box-cont">Bank Address</p>
				<p class="prof-box-cont maskText"><?php echo $databank['bank_address']; ?></p>
			</div>																								
		</div>						
	</div>
</div>
@endsection
@push('custom-scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl, {
      html: true
    })
  })
})
</script>	
<script>
window.onload = function() {
    let elements = document.getElementsByClassName("maskText1");

    for (let i = 0; i < elements.length; i++) {
        let text = elements[i].innerText;
        let words = text.split(" ");
        elements[i].innerText = words[0] + " " + words[1] + " ******";
    }
}
</script>
@endpush