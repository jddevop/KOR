@extends('layouts.app')
@section('title', 'Save Events')
@section('content')
<div class="row">
<div class="col-12">
    <?php if(count($save_data) > 0){ foreach($save_data as $key=>$val){ ?>
	<div class="event-grid-box">
		<div class="event-top">
			<h3><?php if($val->event){ echo $val->event->name; } ?></h3>
			<a href="javascript:void(0)" class="event-save" onClick="event_unsaved('<?php echo $val['event_id']; ?>')">
			<img src="{{ asset('asset/images/save-dark.png') }}" class="img-fluid">
			</a>
		</div>
		<div class="event-info">
			<img src="{{ asset('asset/images/mappin.png') }}" class="img-fluid">
			<p><?php if($val->event){ echo $val->event->address; } ?></p>
		</div>
		<div class="event-info">
			<img src="{{ asset('asset/images/calender.png') }}" class="img-fluid">
			<p><?php if($val->event){ echo date("j M Y", strtotime($val->event->start_date)); ?> To <?php echo date("j M Y", strtotime($val->event->end_date));   }?></p>
		</div>
		<div class="event-info">
			<img src="{{ asset('asset/images/usericn.png') }}" class="img-fluid">
			<p>Role: <?php if($val->event){ echo $val->event->role; } ?></p>
		</div>	
		<div class="row">
				
			<div class="col-12 col-sm-12">
				<a href="{{ route('event_details') }}?id=<?php echo $val['event_id']; ?>" class="view-btn">View Event</a>
			</div>																			
		</div>						
	</div>
 <?php } }else{
 ?>
    <div class="event-grid-box">
            <h5 class="text-center">No data found</h5>
    </div>
 <?php
 }?>
</div>
</div>
@endsection
@push('custom-scripts')
<script>
function event_unsaved(id){
        
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
                    location.reload();
                } else {
                    
                }

            }
        });
    }
</script>
@endpush