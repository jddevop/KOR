<?php if(count($event_data) > 0){ foreach($event_data as $key=>$val){ ?>
<div class="event-grid-box">
	<div class="event-top">
		<h3><?php echo $val->name; ?></h3>
	<?php if($val->event_status==1){ ?>
		<span class="invited">Invited </span>
	<?php }else if($val->event_status==3){?>
	    <span class="open">Applied </span>
	<?php }else if($val->event_status==5){?>
	    <span class="confirmed">Confirmed </span>
	<?php }else if($val->event_status==6){?>
	    <span class="ongoing">Ongoing </span>
	<?php }else if($val->event_status==7){?>
	    <span class="concluded">Completed </span>
	<?php }else if($val->event_status==4){?>
	    <span class="missed">Rejected </span>
	<?php }?>
	</div>
	<div class="event-info">
		<img src="{{ asset('asset/images/mappin.png') }}" class="img-fluid">
		<p><?php echo $val->address; ?></p>
	</div>
	<div class="event-info">
		<img src="{{ asset('asset/images/calender.png') }}" class="img-fluid">
		<p><?php echo date('d M Y', strtotime($val->start_date)); ?> to <?php echo date('d M Y', strtotime($val->end_date)); ?> </p>
	</div>
	<div class="event-info">
		<img src="{{ asset('asset/images/usericn.png') }}" class="img-fluid">
		<p>Role: <?php if($val->role_new==''){ echo $val->role; }else{ echo $val->role_new; } ?> </p>
	</div>	
	<div class="row">
	    
	    <?php if($val->event_status==1 || $val->event_status==2 || $val->event_status==3 || $val->event_status==4){ ?>
	    <div class="col-12 col-sm-12">
				<a href="https://wa.me/<?php echo $support_number; ?>" class="support-btn">WhatsApp Support <img src="{{ asset('asset/images/whatsapp.png') }}" class="img-fluid"></a>
			</div>
	    <div class="col-12">
			<a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>" class="view-btn">view event</a>
		</div>
	    <?php }else if($val->event_status==5){
	    ?>
	    <div class="col-6 col-sm-6">
				<a href="<?php echo $val->whatsapp_group_link; ?>" class="support-btn">Group Chat <img src="{{ asset('asset/images/whatsapp.png') }}" class="img-fluid"></a>
			</div>
			<div class="col-6 col-sm-6">
				<a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>" class="view-btn">view event</a>
			</div>
	    <?php }else if($val->event_status==6){
	    ?>
	    <div class="col-12 col-sm-12">
				<a href="<?php echo $val->whatsapp_group_link; ?>" class="support-btn">Group Chat <img src="{{ asset('asset/images/whatsapp.png') }}" class="img-fluid"></a>
			</div>
			<div class="col-12 col-sm-12">
				<a href="{{ route('shift_detail') }}?id=<?php echo $val->id; ?>" class="confirm-btn">Go to Shift</a>
			</div>
			<div class="col-12 col-sm-12">
				<a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>" class="view-btn">view event</a>
			</div>
	    <?php }else if($val->event_status==7){
	    ?>
	        <div class="col-6 col-sm-6">
				<a href="{{ route('view_shift_detail') }}?id=<?php echo $val->id; ?>" class="confirm-btn">View Shift</a>
			</div>		
			<div class="col-6 col-sm-6">
				<a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>" class="view-btn">View Event</a>
			</div>	
	    <?php }?>
	</div>						
</div>	
<?php } }else{
?>
    <div class="event-grid-box">
        <h5 class="text-center">No data found</h5>
    </div>
<?php
}?>