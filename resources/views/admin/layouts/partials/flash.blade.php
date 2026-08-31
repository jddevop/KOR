@if($message = Session::get('success'))
	<div class="alert alert-success myDiv" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="mdi mdi-check-all"></i>
		{{ $message }}
	</div>
@endif

@if($message = Session::get('danger'))
	<div class="alert alert-danger myDiv" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="mdi mdi-block-helper"></i>
		{{ $message }}
	</div>
@endif
@if($message = Session::get('error'))
	<div class="alert alert-danger myDiv" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="mdi mdi-block-helper"></i>
		{{ $message }}
	</div>
@endif

@if($message = Session::get('info'))
	<div class="alert alert-info myDiv" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="mdi mdi-information"></i>
		{{ $message }}
	</div>
@endif

@if($message = Session::get('warning'))
	<div class="alert alert-warning myDiv" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="mdi mdi-alert"></i>
		{{ $message }}
	</div>
@endif
<div id="errormsg"></div>

<script type="text/javascript">
    setTimeout(function(){
        $('.myDiv').fadeOut(500);
    }, 5000);
</script>


