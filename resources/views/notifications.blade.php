@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="row">
	<div class="col-12">
	    @if(count($view_data) > 0)
	    @foreach($view_data as $val)
	    
	    <?php $url=route('dashboard');
	    ?>
	    
	    <a href="<?php echo $url; ?>" class="text-decoration-none">
		<div class="noti-single">
			<h3 class="noti-title">
			    <?php if($val['type']==6){
			    ?>
			        Event Invitation
			    <?php
			    }else if($val['type']==7){
			    ?>
			        Event confirmation
			    <?php
			    }else if($val['type']==8){
			    ?>
			        Shift updated
			    <?php
			    }else if($val['type']==9){
			    ?>
			        Shift reminder
			    <?php
			    }else if($val['type']==10){
			    ?>
			        Shift reminder
			    <?php
			    }else if($val['type']==11){
			    ?>
			        Document expired
			    <?php
			    }?>
			    
			</h3>
			<p class="noti-desc"><?php echo $val['message']; ?></p>
			<p class="noti-time"><?php echo timeAgo($val['date_time']); ?></p>
		</div>
         </a>
        @endforeach
		 @else
            <div class="noti-single">
            <div class="text-center py-5">
                <h4>No Data Found</h4>
            </div>
          </div>
        @endif				
	</div>
</div>
@endsection
		