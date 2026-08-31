@extends('layouts.app')
@section('title', 'Share')
@section('content')
<div class="row">
	<div class="col-12">
		<form>
			<div class="share-box">
				<div class="input-group mb-0">
					<input type="text" value="{{ route('dashboard') }}" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" id="formLink" readonly>
					<span class="input-group-text" id="basic-addon2"><a onclick="copyLink()"><img src="{{ asset('asset/images/copy.png') }}" class="img-fluid"></a></span>
				</div>							
			</div>
		</form>
	</div>
</div>

<div class="social-share">
	<div class="">
		<a href="mailto:?body={{ route('dashboard') }}">
			<img src="{{ asset('asset/images/icn1.png') }}" class="img-fluid">
		</a>					
	</div>
	<div class="">
		<a href="https://wa.me/?text={{ route('dashboard') }}" target="_blank">
			<img src="{{ asset('asset/images/icn2.png') }}" class="img-fluid">
		</a>					
	</div>
	<div class="">
		<a href="https://telegram.me/share/url?url={{ route('dashboard') }}" target="_blank">
			<img src="{{ asset('asset/images/icn3.png') }}" class="img-fluid">
		</a>					
	</div>
	<div class="">
		<a href="https://www.facebook.com/sharer/sharer.php?u={{ route('dashboard') }}" target="_blank">
			<img src="{{ asset('asset/images/icn4.png') }}" class="img-fluid">
		</a>					
	</div>
															
</div>
@endsection
@push('custom-scripts')
<script>
function copyLink() {
  var copyText = document.getElementById("formLink");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  alert("Link Copied!");
}
</script>
@endpush		