@extends('layouts.app')
@section('title', 'Change Password')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="rp-form-wrap">
		    <div id="showmsg"></div>
			<h2>Change Password</h2>
			<p>Keep your account secure</p>
			<form method="post" action="{{ route('change_password_update') }}" enctype="multipart/form-data">
			    @csrf
		  		{{ method_field('patch') }}	
				<div class="mb-3">
					<label class="form-label">Current Password </label>
					<div class="input-group pwd-input">  
						<input  type="password" class="form-control" id="opassword" name="opassword" placeholder="Enter current password">
						<span class="input-group-text" id="toggleCurPassword"><i class="far fa-eye"></i></span>
					</div>
					<p class="text-danger err_msg" id="msg_opassword"></p>
				</div>		
				<div class="mb-3">
					<label class="form-label">New Password</label>
					<div class="input-group pwd-input">  
						<input  type="password" class="form-control" id="npassword" name="npassword" placeholder="Enter password">
						<span class="input-group-text" id="togglePassword"><i class="far fa-eye"></i></span>
					</div>
					<p class="text-danger err_msg" id="msg_npassword"></p>
				</div>
				<div class="mb-3">
					<label class="form-label">Confirm Password </label>
					<div class="input-group pwd-input">  
						<input  type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter confirm password">
						<span class="input-group-text" id="toggleConfPassword"><i class="far fa-eye"></i></span>
					</div>	
					<p class="text-danger err_msg" id="msg_cpassword"></p>
				</div>		
				<div class="d-grid">
					<button type="button" class="btn btn-primary blue-btn" onClick="change_password_update()">update password</button>
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
					<a href="{{ route('logout') }}" class="blue-btn-link">go to login</a>
					<!-- data-bs-dismiss="modal" -->
				</div>							
			</div>
		</div>
	</div>
</div>
<div class="loadingClass" id="showload">
        <img src="{{ asset('asset/images/loader.gif') }}" alt="loader" />
    </div>
@endsection
@push('custom-scripts')
<script>
	document.getElementById("togglePassword").onclick = function () {
		var password = document.getElementById("npassword");
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
		var confpassword = document.getElementById("cpassword");
		var icon = this.querySelector("i");
		
		if (confpassword.type === "password") {
		confpassword.type = "text";
		icon.className = "far fa-eye-slash";
		} else {
		confpassword.type = "password";
		icon.className = "far fa-eye";
		}
	};  

	document.getElementById("toggleCurPassword").onclick = function () {
		var curpassword = document.getElementById("opassword");
		var icon = this.querySelector("i");
		
		if (curpassword.type === "password") {
		curpassword.type = "text";
		icon.className = "far fa-eye-slash";
		} else {
		curpassword.type = "password";
		icon.className = "far fa-eye";
		}
	};  		
</script>
<script>
function change_password_update() {
    var opassword = $("#opassword").val();
    var npassword = $("#npassword").val();
    var cpassword = $("#cpassword").val();
     $("#showmsg").html('');
    $(".err_msg").html('');
    
    var error = [];
    var i = 0;

    if (opassword == '') {
        error['msg_opassword'] = "Current Password Is Required";
        i++;
    }

    if (npassword == '') {
        error['msg_npassword'] = "New Password Is Required";
        i++;
    }
    if (cpassword == '') {
        error['msg_cpassword'] = "Confirm Password Is Required";
        i++;
    } 
    
    if (npassword && cpassword && npassword !== cpassword) {
        error['msg_cpassword'] = "New Password and Confirm Password do not match";
        i++;
    }
    
    if (i < 1) {
        $.ajax({
            url: '{{ route('change_password_update') }}',
            method: 'post',
            data: {
                'opassword': opassword,
                'npassword': npassword,
                'cpassword': cpassword
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
@endpush
		