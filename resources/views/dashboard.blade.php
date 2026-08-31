@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
	<div class="col-12">
		<h2>Dashboard</h2>
	</div>
	<div class="col-6">
		<div class="dash-whi-box">
			<h5>Upcoming Shifts</h5>
			<h4><?php echo $upcomingshiftCount; ?></h4>
		</div>
	</div>
	<div class="col-6">
		<div class="dash-whi-box">
			<h5>Worked Hours (<?php echo date('M'); ?>)</h5>
			<h4><?php echo get_shift_hours(); ?>h</h4>
		</div>
	</div>				
</div>
<div class="row">
	<div class="col-12">

		<?php /*<p class="dash-grid-title">Shifts</p>
		<div class="dash-grid-box">
			<div class="dg-top mb-0">
				<h3 class="mb-0">No Shifts Scheduled</h3>							
			</div>
		</div>*/?>
		<?php if(count($events_ongoing) > 0){ ?>
		<p class="dash-grid-title"><?php echo date('l, F jS, Y'); ?></p>
		<?php foreach($events_ongoing as $key=>$val){ ?>
		<div class="dash-grid-box">
			<div class="dg-top">
				<h3><?php echo $val->name; ?></h3>
				<?php if($val->current_invitation_status==5){ ?>
				<span class="confirmed">Confirm</span>
				<?php
				}else if($val->current_invitation_status==6){
				?>
				<span class="ongoing">Ongoing</span>
				<?php
				}?>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/mappin.png') }}" class="img-fluid">
				<p><?php echo $val->address; ?></p>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/calender.png') }}" class="img-fluid">
				<p><?php echo date('d M Y', strtotime($val->start_date)); ?> to <?php echo date('d M Y', strtotime($val->end_date)); ?></p>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/usericn.png') }}" class="img-fluid">
				<p>Role: <?php if($val->role_new==''){ echo $val->role; }else{ echo $val->role_new; } ?></p>
			</div>
		 <?php if($val->current_invitation_status==6){ ?>
			<a href="{{ route('shift_detail') }}?id=<?php echo $val->id; ?>">Clock-in/Clock-out</a>
	    <?php }else{
	    ?>
	        <a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>">View Event</a>
	    <?php
	    }?>
		</div>
        <?php } }?>
        
        
        <?php if(count($events_accept) > 0){ ?>
		<p class="dash-grid-title">Upcoming</p>
		<?php foreach($events_accept as $key=>$val){ ?>
		<div class="dash-grid-box">
			<div class="dg-top">
				<h3><?php echo $val->name; ?></h3>
				<?php if($val->current_invitation_status==5){ ?>
				<span class="confirmed">Confirmed</span>
				<?php
				}else if($val->current_invitation_status==6){
				?>
				<span class="ongoing">Ongoing</span>
				<?php
				}?>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/mappin.png') }}" class="img-fluid">
				<p><?php echo $val->address; ?></p>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/calender.png') }}" class="img-fluid">
				<p><?php echo date('d M Y', strtotime($val->start_date)); ?> to <?php echo date('d M Y', strtotime($val->end_date)); ?></p>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/usericn.png') }}" class="img-fluid">
				<p>Role: <?php if($val->role_new==''){ echo $val->role; }else{ echo $val->role_new; } ?></p>
			</div>
			<div class="row">
		 <?php if($val->current_invitation_status==6){ ?>
		    <div class="col-6 col-sm-6">
				<a href="<?php echo $val->whatsapp_group_link; ?>" class="support-btn">Group Chat <img src="{{ asset('asset/images/whatsapp.png') }}" class="img-fluid"></a>
			</div>
			<div class="col-6 col-sm-6">
			<a href="{{ route('shift_detail') }}?id=<?php echo $val->id; ?>">Clock-in/Clock-out</a>
			</div>
	    <?php }else{
	    ?>
	        <div class="col-6 col-sm-6">
				<a href="<?php echo $val->whatsapp_group_link; ?>" class="support-btn">Group Chat <img src="{{ asset('asset/images/whatsapp.png') }}" class="img-fluid"></a>
			</div>
			<div class="col-6 col-sm-6">
	        <a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>">View Event/Shift</a>
	        </div>
	    <?php
	    }?>
	    </div>
		</div>
        <?php } }?>
        
        
        
		<?php foreach($events_applied as $key=>$val){ ?>
		<div class="dash-grid-box">
			<div class="dg-top">
				<h3><?php echo $val->name; ?></h3>
				<?php if($val->current_invitation_status==3){ ?>
				<span class="open">Applied</span>
				<?php }?>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/mappin.png') }}" class="img-fluid">
				<p><?php echo $val->address; ?></p>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/calender.png') }}" class="img-fluid">
				<p><?php echo date('d M Y', strtotime($val->start_date)); ?> to <?php echo date('d M Y', strtotime($val->end_date)); ?></p>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/usericn.png') }}" class="img-fluid">
				<p>Role: <?php echo $val->role; ?></p>
			</div>												
			<a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>">View Event</a>
		</div>	
		<?php } ?>
        
        <?php if(count($view_event) > 0){ ?>
		<p class="dash-grid-title">Open Opportunities</p>
		<?php foreach($view_event as $key=>$val){ ?>
		<div class="dash-grid-box">
			<div class="dg-top">
				<h3><?php echo $val->name; ?></h3>
				<?php if($val->current_invitation_status==0){ ?>
				<span class="open">Open</span>
				<?php }else if($val->current_invitation_status==1){
				?>
				    <span class="invited">invited</span>
				<?php
				}?>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/mappin.png') }}" class="img-fluid">
				<p><?php echo $val->address; ?></p>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/calender.png') }}" class="img-fluid">
				<p><?php echo date('d M Y', strtotime($val->start_date)); ?> to <?php echo date('d M Y', strtotime($val->end_date)); ?></p>
			</div>
			<div class="dg-info">
				<img src="{{ asset('asset/images/usericn.png') }}" class="img-fluid">
				<p>Role: <?php echo $val->role; ?></p>
			</div>												
			<a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>">View Event</a>
		</div>	
		<?php } }?>
		

        <?php $i=0; ?>
        <?php if($bank_address==''){
            $i++;
        }?>
        <?php if($data_user['nationality']=='Irish'){?>
		
		<?php 
			    if($data_user['national_id']=='')
			    {
			$i++;
			}?>
		   
		<?php }else if($data_user['nationality']=='EU'){
		?>
		<?php 
			    if($data_user['national_id']=='')
			    {
        			$i++;
        		}?>
        		
               
    		
		<?php
		}else if($data_user['nationality']=='Non-EU'){?>
		    <?php 
        		    if($data_user['permission_to_work1']=='')
        		    { 
        		        $i++;
        		    }
        		   ?>
        		
		<?php }?>
		
    	  <?php if($i!=0){ $z=0;?> 
		<p class="dash-grid-title">To-Do</p>
		<div class="dash-todo-box">
		    <?php if($data_user['nationality']=='Irish'){?>
		
		<?php 
			    if($data_user['national_id']=='')
			    { $z++;
			?>
			<div class="todo-single">
				<p>National ID/Passport</p>
				<span class="missing">Missing</span>
			</div>
		   <?php }?>
		   
		<?php }else if($data_user['nationality']=='EU'){
		?>
		<?php 
			    if($data_user['national_id']=='')
			    { $z++;
        			?>
        			<div class="todo-single">
        				<p>National ID/Passport</p>
        				<span class="missing">Missing</span>
        			</div>
        	<?php }?>
        	
                
		   
		<?php
		}else if($data_user['nationality']=='Non-EU'){?>
		    <?php
        		    if($data_user['permission_to_work1']=='')
        		    { $z++;
        		   ?>
        		    <div class="todo-single">
        				<p>Permission to Work</p>
        				<span class="missing">Missing</span>
        			</div>
        		   <?php
        		 }?>
        		
		<?php }?>
		<?php if($bank_address==''){
		?>
            <div class="todo-single gap-2">
        				<p>Bank Details</p>
        				<a href="{{ route('update_bank_detail') }}" class="mt-0">Upload Bank Details <img src="{{ asset('asset/images/blue-arrow.png') }}" class="img-fluid"></a>
        				<span class="missing">Missing</span>
        			</div>		
		<?php
		}?>
		<?php if($z > 0){ ?>
			<a href="{{ route('upload_document') }}">Upload your documents <img src="{{ asset('asset/images/blue-arrow.png') }}" class="img-fluid"></a>
		<?php }?>
		</div>
        <?php } ?>
	</div>
</div>
@endsection
		