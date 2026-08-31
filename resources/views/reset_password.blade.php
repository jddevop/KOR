<!doctype html>
<html lang="en">
<head>
	@include('layouts.partials.head')
</head>
<body class="<?php echo $page; ?>"> 
 
	<section class="rp-box">
		<div class="container">
			@include('layouts.partials.navbar') 
			<div class="row">
				<div class="col-12">
					<div class="rp-form-wrap">
					    <div id="showmsg"></div>
						<h2>Reset Password</h2>
						<p>Create a strong new password</p>
						<form action="{{ route('admin.reset_password_update') }}" method="post" enctype="multipart/form-data">	
							<div class="mb-3">
								<label class="form-label">New Password</label>
								<div class="input-group pwd-input">  
									<input  type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
									<span class="input-group-text" id="togglePassword"><i class="far fa-eye"></i></span>
								</div>							
								<p class="text-danger err_msg" id="msg_password"></p>
							</div>
							<div class="mb-3">
								<label class="form-label">Confirm Password </label>
								<div class="input-group pwd-input">  
									<input  type="password" class="form-control" id="confpassword" name="cpassword" placeholder="Enter Confirm Password">
									<span class="input-group-text" id="toggleConfPassword"><i class="far fa-eye"></i></span>
								</div>							
								<p class="text-danger err_msg" id="msg_cpassword"></p>
							</div>		
							<div class="d-grid">
								<button type="button" class="btn btn-primary blue-btn" onClick="do_reset_password()">submit</button>
							</div>																			
						</form>
					</div>
				</div>
			</div>	
			<div class="modal fade" id="pum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pumLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body text-center pum-box">
							<img src="{{ asset('asset/images/confeti.png') }}" class="img-fluid">
							<h2 >Password Updated </h2>
							<p>You can now login with your new password.</p>
							<div class="d-grid">
								<a href="{{ route('login') }}" class="blue-btn-link">go to login</a>
								<!-- data-bs-dismiss="modal" -->
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="loadingClass" id="showload">
        <img src="{{ asset('asset/images/loader.gif') }}" alt="loader" />
    </div>
	@include('layouts.partials.scripts')
	<script>
		document.getElementById("togglePassword").onclick = function () {
			var password = document.getElementById("password");
			var icon = this.querySelector("i");
			
			if (password.type === "password") {
			password.type = "text";
			icon.className = "far fa-eye-slash";
			} else {
			password.type = "password";
			icon.className = "far fa-eye";
			}
		};

		document.getElementById("toggleConfPassword").onclick = function () {
			var confpassword = document.getElementById("confpassword");
			var icon = this.querySelector("i");
			
			if (confpassword.type === "password") {
			confpassword.type = "text";
			icon.className = "far fa-eye-slash";
			} else {
			confpassword.type = "password";
			icon.className = "far fa-eye";
			}
		};  
	</script>
	<script>
	function do_reset_password() {
        var password = $("#password").val();
        var confpassword = $("#confpassword").val();
         $("#showmsg").html('');
        $(".err_msg").html('');
        
        var error = [];
        var i = 0;

        if (password == '') {
            error['msg_password'] = "Password Is Required";
            i++;
        }
        if (confpassword == '') {
            error['msg_cpassword'] = "Confirm Password Is Required";
            i++;
        } 
        
        if (password && confpassword && password !== confpassword) {
            error['msg_cpassword'] = "Password and Confirm Password do not match";
            i++;
        }
        
        if (i < 1) {
            $.ajax({
                url: '{{ route('do_reset_password') }}',
                method: 'post',
                data: {
                    'password': password,
                    'cpassword': confpassword
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#showload').show();
                },
                success: function(result) {
                    $('#showload').hide();
                    if (result.status == 1) {
                        $('#pum').modal('show');
                    } else {
                        $('#showmsg').html(
                            '<div class="alert alert-danger myDiv" role="alert"><i class="mdi mdi-block-helper"></i>' +
                            result.message + '</div>');
                    }

                }
            });
        } else {
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
        }
    }
    </script>
</body>
</html>