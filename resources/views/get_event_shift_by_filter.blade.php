<?php if(count($event_data) > 0){ foreach($event_data as $key=>$val){ ?>
<div>
	<p class="shift-date"><?php echo date("d M Y", strtotime($val->start_date)); ?></p>
	<?php if($val->event_status==6){ ?>
	<a href="{{ route('shift_detail') }}?id=<?php echo $val->id; ?>">
	 <?php }else{
	 ?>
	 <a href="{{ route('event_details') }}?id=<?php echo $val->id; ?>">
	 <?php
	 }?>
		<div class="shift-single">
			<div>
				<h3><?php echo $val->name; ?></h3>
				<p class="shift-desc"> • <?php if($val->role_new==''){ echo $val->role; }else{ echo $val->role_new;} ?></p>
				<?php /*<p class="shift-time"><?php echo calculateHours($val->shift_start_time,$val->shift_end_time); ?></p>*/?>
			</div>
			<?php if($val->event_status==6){ ?>
			    <span class="ongoing">ongoing</span>
			<?php }else if($val->event_status==7){
			?>
			    <span class="concluded">concluded</span>
			<?php
			}else if($val->event_status==5){
			?>
			    <span class="confirmed">confirmed</span>
			<?php
			}else if($val->event_status==2){
			?>
			    <span class="missed">Missed</span>
			<?php
			}?>
		</div>
	</a>
</div>
<?php } }else{
?>
    <div class="event-grid-box">
        <h5 class="text-center">No data found</h5>
    </div>
<?php
}?>