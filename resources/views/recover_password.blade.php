<!doctype html>
<html lang="en">
<head>
	@include('layouts.partials.head')
</head>
<body class="<?php echo $page; ?>" > 
	<section class="rp-box">
		<div class="container">
			@include('layouts.partials.navbar')
			<div class="row">
				<div class="col-12">
					<div class="rp-form-wrap">
					    @include('layouts.partials.flash')
						<h2>Recover Password</h2>
						<p>Enter your registered email to recover password</p>
						<form action="{{ route('do_recover_password') }}" method="post" enctype="multipart/form-data">
						    @csrf
							<div class="mb-3">
								<label class="form-label d-none">Email</label>
								<input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
								@error('email')
    								<p id="error_message" class="text-danger">{{ $message }}</p>
    							@enderror
							</div>
							<div class="d-grid">
								<button type="submit" class="btn btn-primary blue-btn">send otp</button>
							</div>
							<div class="mt-3 btl-link">
								<a href="javascript:void(0)">Back to login</a>
							</div>							
						</form>
					</div>
				</div>
			</div>	
		</div>
	</section>
	@include('layouts.partials.scripts')
</body>
</html>