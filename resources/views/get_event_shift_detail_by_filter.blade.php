<?php if(count($data_shift) > 0){ foreach($data_shift as $key=>$val){ ?>
	<p class="st-date"><?php echo date("d M Y", strtotime($val['clock_in_date_time'])); ?></p>
	<div class="st-single">
		<div>
			<p>Clock In</p>
			<h5><?php echo $val['clock_in_explanatory_note'];?></h5>
		</div>
		<h4 class="st-time"><?php echo date("H:i", strtotime($val['clock_in_date_time'])); ?></h4>
	</div>
	
	<?php if($val['clock_out_date_time']!=''){ ?>
	<p class="st-date"><?php echo date("d M Y", strtotime($val['clock_out_date_time'])); ?></p>
	<div class="st-single">
		<div>
			<p>Clock Out</p>
			<h5><?php echo $val['clock_out_explanatory_note'];?></h5>
		</div>
		<h4 class="st-time-red"><?php echo date("H:i", strtotime($val['clock_out_date_time'])); ?></h4>
	</div>
	<?php }?>
<?php } }else{
?>
    <div class="event-grid-box">
        <h5 class="text-center">No data found</h5>
    </div>
<?php
}?>