@extends('layouts.app')
@section('title', 'Event')
@section('content')
<div class="topbar eventback">
    <a href="javascript:void(0)" onclick="history.back(); return false;">
        <img src="{{ asset('asset/images/back.png') }}" class="img-fluid">
    </a>
    <div>
        <a href="javascript:void(0)" class="event-save" <?php if($save_status==1){?> style="display:none"; <?php } ?>>
            <img src="{{ asset('asset/images/save.png') }}" class="img-fluid" onClick="event_saved()">
        </a>
        <a href="javascript:void(0)" class="event-saved" onClick="event_unsaved()" <?php if($save_status==1){?> <?php }else{?> style="display:none";  <?php } ?>>
            <img src="{{ asset('asset/images/save-dark.png') }}" class="img-fluid">
        </a>
        <a href="javascript:void(0)">
            <img src="{{ asset('asset/images/share.png') }}" class="img-fluid">
        </a>                
    </div>
</div>
<div class="row">
<div class="col-12">
	<div class="ed-top">
	    <?php $get_status=get_event_status($data['id']); ?>
	    <?php if($get_status==0){ ?>
		<span class="open edtag">open</span>
		<?php }else if($get_status==1){
		?>
		    <span class="invited edtag">Invited</span>
		<?php
		}else if($get_status==2){
		?>
		    <span class="missed edtag">Missed</span>
		<?php
		}else if($get_status==3){
		?>
		    <span class="open edtag">Applied</span>
		<?php
		}else if($get_status==4){
		?>
		    <span class="missed edtag">Rejected</span>
		<?php
		}else if($get_status==5){
		?>
		    <span class="confirmed edtag">Confirmed</span>
		<?php
		}else if($get_status==6){
		?>
		    <span class="ongoing edtag">Ongoing</span>
		<?php
		}else if($get_status==7){
		?>
		    <span class="completed edtag">Completed</span>
		<?php
		}?>
		<?php /*<img src="{{ asset('upload/event/'.$data->company_logo) }}" class="img-fluid edicn">*/?>
		
		<img src="{{ asset('upload/event/'.$data->image) }}" class="img-fluid edbanner">
	</div>
	<h2><?php echo $data['name']; ?> </h2>
	<div class="event-info">
		<img src="{{ asset('asset/images/calender.png') }}" class="img-fluid">
		<p><?php echo date("j M Y", strtotime($data['start_date'])); ?> To <?php echo date("j M Y", strtotime($data['end_date'])); ?></p>
	</div>
	<?php foreach($arr_time as $key=>$val){ ?>
	<div class="event-info">
		<img src="{{ asset('asset/images/calender.png') }}" class="img-fluid">
		<p><?php echo $val['start_time']; ?> To <?php echo $val['end_time']; ?> - <?php echo $val['name']; ?></p>
	</div>
	<?php }?>
	<div class="event-info">
		<img src="{{ asset('asset/images/mappin.png') }}" class="img-fluid">						
		<p><?php echo $data['address']; ?></p>
	</div>
	<p class="ed-title"><?php echo $data['short_description']; ?></p>
	<div class="ed-white-box">
		<p class="ed-title">Shift Details</p>
		
		
		<div class="edsd-box edsd-border pb-0">
			<p>Transport</p>
			<p><?php if($data['transport']==1){ ?>Provided<?php }else{?> Not Provided <?php }?></p>
		</div>						
	</div>	
	<div class="mp-box">
		<p class="ed-title">Meeting Point</p>
		<?php $map_url = "https://maps.google.com/maps?q=".$data['meeting_point_lat'].",".$data['meeting_point_long']."&hl=es;z=14&output=embed"; ?>
		<iframe src="<?php echo $map_url; ?>" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>
	<div class="ed-white-box">
		<p class="ed-title">Meeting Point Information</p>
		<p class="ed-desc"><?php echo $data['short_text_meeting_point_address']; ?></p>
	</div>
	<div class="ed-white-box">
		<p class="ed-title">Payment Rate</p>
		<span class="ed-rate">
			€<?php echo number_format($data['payment_rate'], 2); ?> per hour
		</span>
	</div>					
	<div class="ed-white-box">
		<p class="ed-title">Event Description</p>
		<p class="ed-desc"><?php echo $data['description']; ?></p>
	</div>
	<div class="ed-white-box">
		<p class="ed-title">What You'll Be Doing</p>
		<?php echo $data['what_you_will_be_doing']; ?>						
	</div>										
	<div class="ed-white-box">
		<p class="ed-title">General Information</p>
		<p class="ed-desc"><?php echo $data['general_information']; ?></p>
	</div>
</div>	
</div>

<div class="row">
    <?php if($confirm_status==1){ ?>
<div class="col-6 col-sm-6">
	<a href="javascipt:void(0)" class="decline-btn" onClick="event_decline(event)">Not available</a>
</div>
<div class="col-6 col-sm-6">
	<a href="javascipt:void(0)" class="confirm-btn" onclick="event_confirm(event)">Apply</a>
</div>
<?php }?>
<div class="col-12">
    <?php if($whatsaa_status==5 || $whatsaa_status==6 || $whatsaa_status==7){
        ?>
        <a href="<?php echo $data['whatsapp_group_link']; ?>" class="support-btn">Group Chat <img src="{{ asset('asset/images/whatsapp.png') }}" class="img-fluid"></a>
        <a href="https://wa.me/<?php echo $support_number; ?>" class="support-btn">Support <img src="{{ asset('asset/images/whatsapp.png') }}" class="img-fluid"></a>
        
    <?php 
    }else{?>
	<a href="https://wa.me/<?php echo $support_number; ?>" class="support-btn">Support <img src="{{ asset('asset/images/whatsapp.png') }}" class="img-fluid"></a>
    <?php }?>
    
</div>														
</div>	
<div class="loadingClass" id="showload">
    <img src="{{ asset('asset/images/loader.gif') }}" alt="loader" />
</div>
@endsection
@push('custom-scripts')
<script>
    function event_saved(){
        var id='<?php echo $data['id'] ?>';
        $.ajax({
            url: "{{ route('event_saved') }}",
            method: 'post',
            data: {
                'id': id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function() {
                
            },
            success: function(result) {
                
                if (result.status == 1) {
                    $(".event-save").fadeOut(300, function() {
                        $(".event-saved").fadeIn(300);
                    });
                } else {
                    
                }

            }
        });
    }
    function event_unsaved(){
        ;
        var id='<?php echo $data['id'] ?>';
        $.ajax({
            url: "{{ route('event_unsaved') }}",
            method: 'post',
            data: {
                'id': id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSend: function() {
                
            },
            success: function(result) {
                
                if (result.status == 1) {
                    $(".event-saved").fadeOut(300, function() {
                        $(".event-save").fadeIn(300);
                    });
                } else {
                    
                }

            }
        });
    }
    function event_confirm(e){
        e.preventDefault();
        var id='<?php echo $data['id'] ?>';
        $.ajax({
            url: "{{ route('event_confirm') }}",
            method: 'post',
            data: {
                'id': id
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
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }

            }
        });
    }
    function event_decline(e){
        e.preventDefault();
        var id='<?php echo $data['id'] ?>';
        $.ajax({
            url: "{{ route('event_decline') }}",
            method: 'post',
            data: {
                'id': id
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
                    location.reload();
                } else {
                    alert(result);
                }

            }
        });
    }
</script>
@endpush