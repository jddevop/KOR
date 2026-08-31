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
						<h2>Verify OTP</h2>
						<p>Enter the 6-digit code sent to your email</p>
						<form id="otpForm" action="{{ route('otp_chk') }}">
							<div class="otp-container mb-3">
								<input type="text" name="otp1" maxlength="1" class="otp-input">
								<input type="text" name="otp2" maxlength="1" class="otp-input">
								<input type="text" name="otp3" maxlength="1" class="otp-input">
								<input type="text" name="otp4" maxlength="1" class="otp-input">
								<input type="text" name="otp5" maxlength="1" class="otp-input">
								<input type="text" name="otp6" maxlength="1" class="otp-input">
							</div>

							<div class="d-grid">
								<button type="submit" class="btn btn-primary blue-btn">submit</button>
							</div>	
						</form>
						<div class="text-center mv-3">
							<p class="login-link">Didn't receive code?<a href="javascript:void(0)" onClick="resend_otp()">Resend OTP</a></p>							 
						</div>

					</div>
				</div>
			</div>	
		</div>
	</section>

	@include('layouts.partials.scripts')
<script>
  const inputs = document.querySelectorAll(".otp-input");

  inputs.forEach((input, index) => {

    input.addEventListener("input", (e) => {
      input.value = input.value.replace(/[^0-9]/g, '');

      if (input.value && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });

    input.addEventListener("keydown", (e) => {
      if (e.key === "Backspace") {
        if (input.value === "" && index > 0) {
          inputs[index - 1].value = "";
          inputs[index - 1].focus();
          e.preventDefault();
        } else {
          input.value = "";
        }
      }
    });

    input.addEventListener("paste", (e) => {
      e.preventDefault();
      const pasteData = e.clipboardData.getData("text").replace(/[^0-9]/g, '');
      if (pasteData.length === 6) {
        inputs.forEach((inp, i) => {
          inp.value = pasteData[i];
        });
        inputs[5].focus();
      }
    });

  });
  
  const form = document.getElementById("otpForm");
  // FORM SUBMIT VALIDATION
  form.addEventListener("submit", function(e) {
    let otp = '';

    inputs.forEach(input => {
      otp += input.value;
    });

    if (otp.length !== 6) {
      e.preventDefault();
      alert("Please enter complete 6-digit OTP");
    }
  });
  
</script>
<script type="text/javascript">
	function resend_otp(){
		
			$.ajax({
			url: '{{ route("resend_otp") }}',
			method: 'post',
			data: {},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			beforeSend: function(){
				
			},
			success: function(result) {	
					if(result.status==1){
						alert(result.message);
					}else{
						alert(result.message);
					}
			}
		})
	}
</script>
</body>
</html>