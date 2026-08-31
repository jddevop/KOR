@extends('layouts.app')
@section('title', 'FAQ')
@section('content')
<div class="row">
<div class="col-12">
	<div class="faq-box">
		<div class="accordion" id="accordionExample">
			<div class="accordion" id="accordionPanelsStayOpenExample">
			    <?php $i=1; foreach($data_faq as $key=>$val){ ?>
				<div class="accordion-item">
					<h2 class="accordion-header" id="panelsStayOpen-heading<?php echo $i; ?>">
					<button class="accordion-button <?php if($i!=1){?> collapsed <?php } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $i; ?>" aria-expanded="<?php if($i==1){ ?>true <?php }else{?>false <?php }?>" aria-controls="panelsStayOpen-collapse<?php echo $i; ?>">
						<?php echo $val['name']; ?>
					</button>
					</h2>
					<div id="panelsStayOpen-collapse<?php echo $i; ?>" class="accordion-collapse collapse <?php if($i==1){ ?>show <?php } ?>" aria-labelledby="panelsStayOpen-heading<?php echo $i; ?>">
					<div class="accordion-body">
						<?php echo $val['description']; ?>
					</div>
					</div>
				</div>
				<?php $i++; }?>
			</div>
		</div>																											
	</div>
</div>
</div>
@endsection
		