@if($message = Session::get('success'))
	<div class="alert alert-success myDiv" role="alert">
		<i class="mdi mdi-check-all"></i>
		{{ $message }}
	</div>
@endif

@if($message = Session::get('danger'))
	<div class="alert alert-danger myDiv" role="alert">
		<i class="mdi mdi-block-helper"></i>
		{{ $message }}
	</div>
@endif

@if($message = Session::get('info'))
	<div class="alert alert-info myDiv" role="alert">
		<i class="mdi mdi-information"></i>
		{{ $message }}
	</div>
@endif

@if($message = Session::get('warning'))
	<div class="alert alert-warning myDiv" role="alert">
		<i class="mdi mdi-alert"></i>
		{{ $message }}
	</div>
@endif
@if($message = Session::get('error'))
	<div class="alert alert-danger myDiv" role="alert">
		<i class="mdi mdi-block-helper"></i>
		{{ $message }}
	</div>
@endif
@if($message = Session::get('warning1'))
	<div class="alert alert-warning myDiv" role="alert">
		<i class="mdi mdi-alert"></i>
		@foreach($message as $val)
			{{ $val }}
			</br>
		@endforeach 
	</div>
@endif
<div id="errormsg"></div>

<script type="text/javascript">
    setTimeout(function(){
        $('.myDiv').fadeOut(500);
    }, 5000);
</script>


