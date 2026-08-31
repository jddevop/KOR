<!doctype html>
<html lang="en">
<head>
	@include('layouts.partials.head')
	
</head>
<body class="<?php echo $page; ?>"> 
	<section class="login-box">
		<div class="container">
		    @include('layouts.partials.navbar')
			<div class="row">
				<div class="col-12 mb-50">
					<img src="{{ asset('asset/images/logo.svg') }}" class="img-fluid img-center" alt="logo">
				</div>					
			</div>	
			<div class="row">
				<div class="col-12">
					<div class="login-form-wrap">
					    @include('layouts.partials.flash')
						<h2>Login</h2>

						<form action="{{ route('login_chk') }}" method="post" enctype="multipart/form-data">
						    @csrf
						    <input type="hidden" name="token" id="token" class="token"/>
							<div class="mb-3">
								<label class="form-label">Email</label>
								<input type="text" class="form-control" name="email" id="email" placeholder="Enter email" >
								@error('email')
    								<p id="error_message" class="text-danger">{{ $message }}</p>
    							@enderror
							</div>
							<div class="mb-3">
								<label class="form-label">Password</label>
								<div class="input-group pwd-input">  
									<input  type="password" class="form-control" name="password" id="password" placeholder="Enter password" >
									<span class="input-group-text" id="togglePassword"><i class="far fa-eye"></i></span>
								</div>							
								@error('password')
    								<p id="error_message" class="text-danger">{{ $message }}</p>
    							@enderror
							</div>
							<div class="mb-3 fp-link">
								<a href="{{ route('recover_password') }}">Forgot Password</a>
							</div>
							<div class="d-grid">
								<button type="submit" class="btn btn-primary blue-btn">Login</button>
							</div>
						</form>

					</div>
				</div>
				<div class="text-center mv-3">
					<p class="login-link">Don't have an account?<a href="{{ route('register') }}">Register</a></p>
				</div>
			</div>	
		</div>
	</section>
	
<div class="modal" id="modal_noti" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">NOTIFICATION</h5>
      </div>
      <div class="modal-body">
        <p style="margin-bottom: 0px;">
          KOR wants to send you notifications
        </p>
      </div>
      <div class="modal-footer" style="display: block;text-align: center;">
        <button type="button" class="btn btn-secondary" style="width: 166px;" id="enableNotifications">
          Allow Notifications
        </button>
      </div>
    </div>
  </div>
</div>
	

<div class="modal" id="modal_pwa" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Install App</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="functionToExecutex()"></button>
      </div>
      <div class="modal-body">
        <div class="row">
                <div class="col-12 px-3">
                    <div class="float-left" style="width: 50px;
    float: left;">
                        <img src="{{ asset('asset/icon/96.png') }}" class="img-fluid" style="width: 50px;    height: 50px;">
                    </div>
                    <div class="float-left px-2" style="width: calc(100% - 50px);float: left;">
                        <h4 class="mb-0">KOR</h4>
                        <p class="">kor.com</p>
                    </div>
                </div>
                </div>
                
                <p style="margin-bottom: 0px;">
                <button class="btn btn-primary w-100 rounded-pill" type="button"
                onclick="tInstall()"
                >
                    <i class="fa-solid fa-mobile-screen-button"></i> Install APP
                  </button>
                </p>
      </div>
      <div class="modal-footer" style="display: block;text-align: center;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100px;" onclick="functionToExecutex()">Close</button>
       
      </div>
    </div>
  </div>
</div>	

	
	
<div class="modal" id="modal_pwa_mob" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Install App</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="functionToExecute()"></button>
      </div>
      <div class="modal-body">
        <div class="row">
                <div class="col-12 px-3">
                    <div class="float-left" style="width: 50px;
    float: left;">
                        <img src="{{ asset('asset/icon/96.png') }}" class="img-fluid" style="width: 50px;    height: 50px;">
                    </div>
                    <div class="float-left px-2" style="width: calc(100% - 50px);
    float: left;">
                        <h4 class="mb-0">KOR</h4>
                        <p class="">kor.com</p>
                    </div>
                </div>
                </div>
                
                <p style="margin-bottom: 0px;">
					<h4>Install APP</h4>
                	<h5>Use Safari and click <img src="{{ asset('asset/icon/upload.png') }}" height="20px" width="20px"> and choose "Add to Home Screen".</h5>
                </p>
      </div>
      <div class="modal-footer" style="display: block;text-align: center;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100px;" onclick="functionToExecute()">Close</button>
       
      </div>
    </div>
  </div>
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
	</script>
	
<script>
    /*if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("./firebase-messaging-sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }*/
</script> 

<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>
    <script src="{{ asset('asset/js/firebase.js') }}"></script>
    
   
<script src="{{ asset('asset/js/install-app.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    var isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);

    // etect standalone (Android + iOS)
    var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

    if (isStandalone) {
        return; // app already installed → modal na open karo
    }

    if (isIOS) {

        setTimeout(function () {

            var now = new Date().getTime();
            var setupTime = localStorage.getItem('setupTime');

            if (!setupTime) {
                localStorage.setItem('setupTime', now);
                setupTime = now;
            }

            $("#modal_pwa_mob").show();

        }, 2000);
    }

});
</script>

<script type="text/javascript">
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {

    e.preventDefault();

    const dp = getPWADisplayMode();

    if (dp === 'browser') {
     
        deferredPrompt = e;

        setTimeout(function () {

            var now = new Date().getTime();
            var setupTime = localStorage.getItem('setupTime');

            if (!setupTime) {
                localStorage.setItem('setupTime', now);
                setupTime = now;
            }

            /*if (now - setupTime > 600000) {*/
                $('#modal_pwa').modal('show');
            /*}*/

        }, 2000);
    }
});

function getPWADisplayMode() {
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches;

    if (document.referrer.startsWith('android-app://')) {
        return 'twa';
    } else if (navigator.standalone || isStandalone) {
        return 'standalone';
    }
    return 'browser';
}
</script>
 <script type="text/javascript">
function functionToExecute(){
    
        	jQuery('#modal_pwa_mob').hide();
        	localStorage.setItem('popState','shown');

        	var now = new Date().getTime();
        	localStorage.setItem('setupTime', now);
        }

    	function functionToExecutex(){
        	jQuery('#modal_pwa').hide();
        	localStorage.setItem('popState','shown');

        	var now = new Date().getTime();
        	localStorage.setItem('setupTime', now);
        }    
</script>
</body>
</html>