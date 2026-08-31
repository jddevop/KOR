@extends('layouts.app')
@section('title', 'Settings')
@section('content')
	<div class="row">
		<div class="col-12">
		    @include('layouts.partials.navbar')
			<div class="setting-box">
				<a href="{{ route('edit_profile') }}" class="blue-set-link">
					<span>Edit Profile</span>
					<img src="{{ asset('asset/images/edit.png') }}" class="img-fluid">
				</a>
				<a href="{{ route('change_password') }}" class="blue-set-link">
					<span>Change Password</span>
					<img src="{{ asset('asset/images/edit.png') }}" class="img-fluid">
				</a>
				<div class="set-link">
					<a href="{{ route('annual_leave') }}">
						Annual Leave
					</a>
				</div>
				<div class="set-link">
					<a href="{{ route('notifications') }}">
						Notifications
					</a>
				</div>
				<?php if($dataemp['doc']!=''){ ?>
				<div class="set-link">
					<a href="{{ $dataemp['doc'] }}" target="_blank">
						Terms of Employment
					</a>							
				</div>
				<?php }?>
				<div class="set-link">
					<a href="{{ route('faq') }}">
						Help & Support
					</a>								
				</div>	
				<div class="set-link no-border">
					<a href="{{ route('share_app') }}">
						Share App
					</a>								
				</div>																		


										
				<a href="javascript:void(0)" class="red-set-link" data-bs-toggle="modal" data-bs-target="#closeAccount">
					<span>Close Account</span>
					<img src="{{ asset('asset/images/close.png') }}" class="img-fluid">
				</a>												
			</div>
		</div>
	</div>  
	
	<div class="modal fade" id="closeAccount"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="closeAccountLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body ca-modal">
					<img src="{{ asset('asset/images/close-account.png') }}" class="img-fluid">
					<h2>Close Account</h2>
					<p>Are you sure you want to close your account? You will no longer be considered for future shifts</p>
					<form>
						<div class="mb-3">
							<label class="form-label d-none">Reason <sup class="text-danger d-none">*</sup></label>
							<input type="text" class="form-control" name="reason" id="reason" placeholder="Enter reason why you're leaving">
							
							<p class="text-danger err_msg text-start" id="msg_reason"></p>
						</div>
						<div class="row">
							<div class="col-6">
								<button type="button" class="btn btn-secondary cc-btn" onclick="delete_account()">confirm close</button>
							</div>
							<div class="col-6">
								<button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">cancel</button>
							</div>
						</div>
					</form>
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
	function delete_account(){
	    var reason = $("#reason").val();
	    $(".err_msg").html('');
        var error = [];
        var i = 0;

        if (reason == '') {
            error['msg_reason'] = "Reason Is Required";
            i++;
        }
        if (i < 1) {
	        $.ajax({
                url: "{{ route('delete_account') }}",
                method: 'post',
                data: {
                    'reason': reason
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
                        window.location.href = "{{ route('logout') }}";
                    } else {
                        alert(result.message);
                    }

                }
            });
        }else{
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
        }
	}
</script>
@endpush
		