<!doctype html>
<html lang="en">
<head>
	@include('layouts.partials.head')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css"/>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="<?php echo $page; ?>" > 
  
	<section class="register-box">
		<div class="container">
			@include('layouts.partials.navbar')			
			<div class="row">
				<div class="col-12 mb-30">
					<img src="{{ asset('asset/images/logo.svg') }}" class="img-fluid reg-logo" alt="logo">
				</div>					
			</div>	
			<div class="row">
				<div class="col-12">
					<div class="login-form-wrap">
						<h2 class="reg-title"  data-step="1">Basic Information</h2>
						<h2 class="reg-title d-none" data-step="2">Your Experience</h2>
						<h2 class="reg-title d-none" data-step="3">Documents</h2>
						<div class="progress my-3">
							<div class="progress-bar" id="formProgress" style="width:33%"></div>
						</div>
						<form id="form_reg" method="post" enctype="multipart/form-data">
							
							<div class="step1">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">First Name <sup class="text-danger">*</sup></label>
											<input type="text" class="form-control" placeholder="Enter first name" id="first_name" name="first_name">
											<p class="text-danger err_msg" id="msg_first_name"></p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Middle and Last Name(s) <sup class="text-danger">*</sup></label>
											<input type="text" class="form-control" placeholder="Enter last name" id="last_name" name="last_name">
											<p class="text-danger err_msg" id="msg_last_name"></p>
										</div>
									</div>
								</div>						
								<div class="mb-3">
									<label class="form-label">Email <sup class="text-danger">*</sup></label>
									<input type="text" class="form-control" placeholder="Enter email" id="email" name="email">
									<p class="text-danger err_msg" id="msg_email"></p>
								</div>
								<div class="mb-3">
									<label class="form-label">Phone <sup class="text-danger">*</sup></label>
									<input type="tel" class="form-control" placeholder="Enter phone" id="phone" name="phone">
									<p class="text-danger err_msg" id="msg_phone"></p>
								</div>							
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Gender <sup class="text-danger">*</sup></label>
											<select class="form-select" aria-label="Default select example" id="gender" name="gender">
												<option value="">Select Gender</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
												<option value="Prefer not to say">Prefer not to say</option>
											</select>
											<p class="text-danger err_msg" id="msg_gender"></p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">Date of birth <sup class="text-danger">*</sup></label>
											<input type="date" class="form-control" placeholder="Enter Date of birth" id="birth_date" name="birth_date" max="<?php echo date('Y-m-d'); ?>">
											<p class="text-danger err_msg" id="msg_birth_date"></p>
										</div>
									</div>
								</div>								
								<div class="mb-3">
									<label class="form-label">Password <sup class="text-danger">*</sup></label>
									<div class="input-group pwd-input">  
										<input  type="password" class="form-control" id="password" placeholder="Enter password" id="password" name="password">
										<span class="input-group-text" id="togglePassword"><i class="far fa-eye"></i></span>
									</div>							
									<p class="text-danger err_msg" id="msg_password"></p>
								</div>
								<div class="mb-3">
									<label class="form-label">Confirm Password <sup class="text-danger">*</sup></label>
									<div class="input-group pwd-input">  
										<input  type="password" class="form-control" id="confpassword" placeholder="Enter confirm password" id="cpassword" name="cpassword">
										<span class="input-group-text" id="toggleConfPassword"><i class="far fa-eye"></i></span>
									</div>							
									<p class="text-danger err_msg" id="msg_cpassword"></p>
								</div>							
								<div class="d-grid mb-3">
									<button type="button" class="btn btn-primary blue-btn">next</button>
								</div>
							</div>


							<div class="step2 d-none">
								<div class="mb-3">
									<label class="form-label">Nationality<sup class="text-danger">*</sup></label>

									<div class="row">
										<div class="col-md-4">
											<label class="radio-option">
												<span>Irish</span>
												<input type="radio" name="nationality" value="Irish" checked>
												<span class="radio-icon"></span>
											</label>
										</div>
										<div class="col-md-4">
											<label class="radio-option">
												<span>EU</span>
												<input type="radio" name="nationality" value="EU">
												<span class="radio-icon"></span>
											</label>
										</div>
										<div class="col-md-4">
											<label class="radio-option">
												<span>Non-EU</span>
												<input type="radio" name="nationality" value="Non-EU">
												<span class="radio-icon"></span>
											</label>
										</div>																		
									</div>


									<p class="text-danger d-none">validation</p>
								</div>	

								<div class="mb-3">
									<label class="form-label">Where are you currently based?<sup class="text-danger">*</sup></label>
									<select class="form-select" id="city_id" name="city_id">
										<option value="">Select city</option>
										<?php foreach($city_data as $key=>$val){ ?>
										    <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
										<?php }?>
									</select>
									<p class="text-danger err_msg" id="msg_city_id"></p>
								</div>

								<div class="mb-3 hl-wrap">
									<label class="form-label">How long have you been in Ireland?<sup class="text-danger">*</sup></label>
									<select class="form-select" id="experience_level_id" name="experience_level_id">
										<option value="">Select </option>
										
										<?php foreach($experience_level_data as $key=>$val){ ?>
										    <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
										<?php }?>
									</select>
									<p class="text-danger err_msg" id="msg_experience_level_id"></p>
								</div>							

								<div class="mb-3 el-wrap">
									<label class="form-label">English Level<sup class="text-danger">*</sup></label>
									<select class="form-select" id="english_level" name="english_level">
										<option value="">Select level</option>
										
										<?php foreach($english_level_data as $key=>$val){ ?>
										    <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
										<?php }?>
										
									</select>
									<p class="text-danger err_msg" id="msg_english_level"></p>
								</div>

								<div class="mb-3">
									<label class="form-label">Do you have experience in Ireland in any of these areas?<sup class="text-danger">*</sup></label>
									<select class="form-select multi-option_exp" style="width: 100%;" multiple="multiple" id="area_experience" name="area_experience[]">
									    
									    <?php foreach($occupations_data as $key=>$val){ ?>
										    <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
										<?php }?>
									</select>
									<p class="text-danger err_msg" id="msg_area_experience"></p>
								</div>							

								<div class="mb-3">
									<label class="form-label">Additional Experience / Skills / Achievements</label>
									<textarea class="form-control" id="additional_experience" placeholder="This helps us match you to roles that fit your
profile" rows="3" name="additional_experience"></textarea>
									<p class="text-danger err_msg" id="msg_additional_experience"></p>
								</div>

								<div class="mb-3">
									<label class="form-label">How did you hear about us?<sup class="text-danger">*</sup></label>
									<select class="form-select" id="hear_about_us" name="hear_about_us">
										<option value="">Select an option</option>
										<option value="I have worked with you before">I have worked with you before</option>
										<option value="Referral / Friend / Colleague">Referral / Friend / Colleague</option>
										<option value="Social Media">Social Media</option>
										<option value="Event / Career Fair">Event / Career Fair</option>
										<option value="Other">Other</option>
									</select>
									<p class="text-danger err_msg" id="msg_hear_about_us"></p>
								</div>

								<div class="mb-3">
									<label class="form-label">General Availability<sup class="text-danger">*</sup></label>
									<select class="form-select multi-option" style="width: 100%;" multiple="multiple" id="general_availability" name="general_availability[]">
										<option value="Weekdays">Weekdays</option>
										<option value="Weekends">Weekends</option>
										<option value="Evening shifts">Evening shifts</option>
										<option value="Day shifts">Day shifts</option>
										<option value="Fully flexible">Fully flexible</option>
									</select>
									<p class="text-danger err_msg" id="msg_general_availability"></p>
								</div>		
													

								<div class="row mb-3">
									<div class="col-6 d-grid">
										<button type="button" class="btn btn-primary white-btn">back</button>									
									</div>
									<div class="col-6 d-grid">
										<button type="button" class="btn btn-primary blue-btn">next</button>
									</div>
								</div>
							</div>
							
							<div class="step3 d-none">
								<div class="mb-3">
									<label class="form-label">Profile Picture (Headshot)<sup class="text-danger">*</sup></label>
									<div class="dropzone" data-input="file1">
										<div class="drop-title">
											<p>Click to upload file</p>
											<img src="{{ asset('asset/images/upload.png') }}" class="img-fluid drop-upload" >
										</div>
										<input type="file" id="file1" name="profile_picture" hidden>
										<div class="preview"></div>
									</div>
									<p class="text-danger err_msg" id="msg_profile_picture"></p>
								</div>	
								
								<div class="mb-3 ptw-wrap">
									<label class="form-label">Permission to Work<sup class="text-danger">*</sup></label>
									<div class="row">
										<div class="col-md-6">
											<div class="dropzone" data-input="file2">
										<div class="drop-title">
											<p>Click to upload file</p>
											<img src="{{ asset('asset/images/upload.png') }}" class="img-fluid drop-upload">
										</div>
												<input type="file" id="file2" name="permission_to_work1"  hidden>
												<div class="preview"></div>
											</div>
										<p class="text-danger err_msg" id="msg_permission_to_work1"></p>	
										</div>
										<div class="col-md-6">
											<div class="dropzone" data-input="file3">
										<div class="drop-title">
											<p>Click to upload file</p>
											<img src="{{ asset('asset/images/upload.png') }}" class="img-fluid drop-upload">
										</div>
												<input type="file" id="file3" name="permission_to_work2" hidden>
												<div class="preview"></div>
											</div>
											<p class="text-danger err_msg" id="msg_permission_to_work2"></p>
										</div>
									</div>
									
								</div>								

								<div class="mb-3 ed-wrap" >
									<label class="form-label">Expiry Date <sup class="text-danger">*</sup></label>
									<input type="date" class="form-control" id="expiry_date" name="expiry_date" placeholder="" >
									<p class="text-danger err_msg" id="msg_expiry_date"></p>
								</div>
								
								<div class="mb-3 ni-wrap">
									<label class="form-label">National ID/Passport <sup class="text-danger">*</sup></label>
									<div class="dropzone" data-input="file4">
										<div class="drop-title">
											<p>Click to upload file</p>
											<img src="{{ asset('asset/images/upload.png') }}" class="img-fluid drop-upload">
										</div>
										<input type="file" id="file4" name="national_id" hidden>
										<div class="preview"></div>
									</div>
									<p class="text-danger err_msg" id="msg_national_id"></p>
								</div>
								
								<div class="mb-3">
									<label class="form-label">Upload CV</label>
									<div class="dropzone" data-input="file5">
										<div class="drop-title">
											<p>Click to upload file</p>
											<img src="{{ asset('asset/images/upload.png') }}" class="img-fluid drop-upload">
										</div>
										<input type="file" id="file5" name="cv" hidden>
										<div class="preview"></div>
									</div>
									<p class="text-danger err_msg" id="msg_cv"></p>
								</div>								

								<div class="mb-3">
									<div class="d-flex">
										<label class="form-label">PPS Number ? </label>
										<button type="button" class="btn btn-secondary tooltip-btn" data-bs-toggle="tooltip" data-bs-html="true" title="<p>Don't have a PPS number yet? You can add it later in your profile</p>">
											<img src="{{ asset('asset/images/tooltip.png') }}" class="img-fluid">
										</button>										
									</div>								
									<input type="text" class="form-control" id="pps_number" name="pps_number" placeholder="Enter PPS number">
									<p class="text-danger err_msg" id="msg_pps_number"></p>
								</div>

								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" value="1" id="concentcheck">
									<label class="form-check-label" for="concentcheck">
										I consent to my data being stored and used for recruitment and event staffing purposes.
									</label>
									<p class="text-danger err_msg" id="msg_consent"></p>
								</div>

								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" value="1" id="termscheck">
									<label class="form-check-label" for="termscheck">
										I have read and agreed to the <a href="{{ $dataemp['doc'] }}" target="_blank">Terms of Employment</a>.
									</label>
									<p class="text-danger err_msg" id="msg_agree"></p>
								</div>							

								<div class="row mb-3">
									<div class="col-6 d-grid">
										<button type="button" class="btn btn-primary white-btn">back</button>									
									</div>
									<div class="col-6 d-grid">
										<button type="button" class="btn btn-primary blue-btn">finish</button>
									</div>
								</div>
							</div>							

						</form>

					</div>
				</div>
				<div class="text-center mv-3">
					<p class="login-link">Already have an account?<a href="{{ route('login') }}">Login</a></p>
				</div>
			</div>	
		</div>
	</section>
	<div class="loadingClass" id="showload">
        <img src="{{ asset('asset/images/loader.gif') }}" alt="loader" />
    </div>
	@include('layouts.partials.scripts')
	<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
			tooltipTriggerList.map(function (tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl, {
				html: true
				})
			})
		})
	</script>		

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

		const input = document.querySelector("#phone");
		const iti =window.intlTelInput(input, {
			initialCountry: "ie",
			separateDialCode: true,
			geoIpLookup: function(callback) {
			fetch("https://ipapi.co/json")
				.then(res => res.json())
				.then(data => callback(data.country_code))
				.catch(() => callback("us"));
			},
			separateDialCode: true,
		});		

		$(document).ready(function() {
			$('.multi-option_exp').select2({
				placeholder: "Select an option",
				allowClear: true
			});
		});	
		$(document).ready(function() {
			$('.multi-option').select2({
				placeholder: "Select an option",
				allowClear: true
			});
		});	
	</script>

	<script>
		document.querySelectorAll(".dropzone").forEach(zone => {

			const inputId = zone.getAttribute("data-input");
			const fileInput = document.getElementById(inputId);
			const preview = zone.querySelector(".preview");

			zone.addEventListener("click", () => fileInput.click());

			zone.addEventListener("dragover", (e) => {
				e.preventDefault();
				zone.classList.add("dragover");
			});

			zone.addEventListener("dragleave", () => {
				zone.classList.remove("dragover");
			});

			zone.addEventListener("drop", (e) => {
				e.preventDefault();
				zone.classList.remove("dragover");
				fileInput.files = e.dataTransfer.files;
				handleFile(e.dataTransfer.files[0]);
			});

			fileInput.addEventListener("change", () => {
				handleFile(fileInput.files[0]);
			});

			function handleFile(file) {
				preview.innerHTML = "";

				const name = document.createElement("p");
				name.textContent = file.name;
				preview.appendChild(name);

				if (file.type.startsWith("image/")) {
				const reader = new FileReader();
				reader.onload = function(e) {
					const img = document.createElement("img");
					img.src = e.target.result;
					preview.appendChild(img);
				};
				reader.readAsDataURL(file);
				}
			}

		});		
	</script>
	<script>
		const step1 = document.querySelector('.step1');
		const step2 = document.querySelector('.step2');
		const step3 = document.querySelector('.step3');

		const title1 = document.querySelector('.reg-title[data-step="1"]');
		const title2 = document.querySelector('.reg-title[data-step="2"]');
		const title3 = document.querySelector('.reg-title[data-step="3"]');

		const progress = document.getElementById('formProgress');

		document.querySelector('.step1 .blue-btn').onclick = function(){
		    
		    var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var gender = $("#gender").val();
            var birth_date = $("#birth_date").val();
            var password = $("#password").val();
            var cpassword = $("#confpassword").val();
		    $(".err_msg").html('');
       
            var error = [];
            var i = 0;
    
            if (first_name == '') {
                error['msg_first_name'] = "First Name Is Required";
                i++;
            }
            
            if (last_name == '') {
                error['msg_last_name'] = "Last Name Is Required";
                i++;
            }
            if (email == '') {
        		error['msg_email'] = "Email Is Required";
        		i++;
        	} else {
        		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        		if (!regex.test(email)) {
        			error['msg_email'] = "the Email is incorrect";
        			i++;
        		}
        	}
        	
        	if (phone == '') {
                error['msg_phone'] = "Phone Is Required";
                i++;
            }
            if (gender == '') {
                error['msg_gender'] = "Gender Is Required";
                i++;
            }
            if (birth_date == '') {
                error['msg_birth_date'] = "Birth Date Is Required";
                i++;
            }
            
            if (password == '') {
                error['msg_password'] = "Password Is Required";
                i++;
            }
            if (cpassword == '') {
                error['msg_cpassword'] = "Confirm Password Is Required";
                i++;
            } 
            
            if (password && cpassword && password !== cpassword) {
                error['msg_cpassword'] = "Password and Confirm Password do not match";
                i++;
            }
        	
            if (i < 1) {
        			step1.classList.add('d-none');
        			step2.classList.remove('d-none');
        
        			title1.classList.add('d-none');
        			title2.classList.remove('d-none');
        
        			progress.style.width = "66%";
            }else{
                for (var key in error) {
                    $('#' + key).html(error[key]);
                }
            }
		};

		document.querySelector('.step2 .white-btn').onclick = function(){
			step2.classList.add('d-none');
			step1.classList.remove('d-none');

			title2.classList.add('d-none');
			title1.classList.remove('d-none');

			progress.style.width = "33%";
		};

		document.querySelector('.step2 .blue-btn').onclick = function(){
		    
		    var nationality = $('input[name="nationality"]:checked').val();
		    var city_id = $("#city_id").val();
		    var experience_level_id = $("#experience_level_id").val();
		    var english_level = $("#english_level").val();
		    var area_experience = $("#area_experience").val();
            var additional_experience = $("#additional_experience").val();
            var hear_about_us = $("#hear_about_us").val();
            var general_availability = $("#general_availability").val();
        
		    
		    $(".err_msg").html('');
        
            var error = [];
            var i = 0;
    
            if (city_id == '') {
                error['msg_city_id'] = "City Is Required";
                i++;
            }
            if(nationality=='EU' || nationality=='Non-EU')
            {
                if (experience_level_id == '') {
                    error['msg_experience_level_id'] = "How long have you been in ireland Is Required";
                    i++;
                }
                if (english_level == '') {
                    error['msg_english_level'] = "English Level Is Required";
                    i++;
                }
            }
            if (!area_experience || area_experience.length === 0) {
                error['msg_area_experience'] = "Area Experience Is Required";
                i++;
            }
            /*if (additional_experience == '') {
                error['msg_additional_experience'] = "Additional Experience Is Required";
                i++;
            }*/
            if (hear_about_us == '') {
                error['msg_hear_about_us'] = "About Us Is Required";
                i++;
            }
            if (!general_availability || general_availability.length === 0) {
                error['msg_general_availability'] = "General Availability Is Required";
                i++;
            }
            if (i < 1) {
        			step2.classList.add('d-none');
        			step3.classList.remove('d-none');
        
        			title2.classList.add('d-none');
        			title3.classList.remove('d-none');
        
        			progress.style.width = "100%";
            }else{
                for (var key in error) {
                    $('#' + key).html(error[key]);
                }
            }
		};

		document.querySelector('.step3 .white-btn').onclick = function(){
			step3.classList.add('d-none');
			step2.classList.remove('d-none');

			title3.classList.add('d-none');
			title2.classList.remove('d-none');

			progress.style.width = "66%";
		};
		
		document.querySelector('.step3 .blue-btn').onclick = function(){
		    const countryData = iti.getSelectedCountryData();
		    var nationality = $('input[name="nationality"]:checked').val();
		    var profile_picture = $("#file1").val();
		    var profile_picture_input = document.getElementById("file1");
		    var profile_file = profile_picture_input.files[0];
		    var permission_to_work1 = $("#file2").val();
		    var permission_to_work1_input = document.getElementById("file2");
		    var permission_to_work1_file = permission_to_work1_input.files[0];
		    var permission_to_work2 = $("#file3").val();
		    var permission_to_work2_input = document.getElementById("file3");
		    var permission_to_work2_file = permission_to_work2_input.files[0];
		    var cv = $("#file5").val();
		    var cv_input = document.getElementById("file5");
		    var cv_file = cv_input.files[0];
		    var national_id = $("#file4").val();
		    var national_id_input = document.getElementById("file4");
		    var national_id_file = national_id_input.files[0];
		    var expiry_date = $("#expiry_date").val();
		    
		    $(".err_msg").html('');
        
            var error = [];
            var i = 0;
           
            if (profile_picture == '') {
                error['msg_profile_picture'] = "Profile Picture Is Required";
                i++;
            }else if (profile_file && profile_file.size > (2 * 1024 * 1024)) {
                error['msg_profile_picture'] = "The profile picture size exceeds 2MB. Please select a smaller profile picture.";
                i++;
        
                
            }
            if(nationality=='Non-EU')
            {
                if (permission_to_work1 == '') {
                    error['msg_permission_to_work1'] = "Permission to Work1 Is Required";
                    i++;
                }else if (permission_to_work1_file && permission_to_work1_file.size > (2 * 1024 * 1024)) {
                    error['msg_permission_to_work1'] = "The permission to work size exceeds 2MB. Please select a smaller permission to work.";
                    i++;
                    
                }
                if (permission_to_work2 == '') {
                   
                }else if (permission_to_work2_file && permission_to_work2_file.size > (2 * 1024 * 1024)) {
                    error['msg_permission_to_work2'] = "The permission to work size exceeds 2MB. Please select a smaller permission to work.";
                    i++;
                }
                if (expiry_date == '') {
                    error['msg_expiry_date'] = "Expiry Date Is Required";
                    i++;
                }
            }
            if(nationality=='Irish' || nationality=='EU')
            {
               if (national_id == '') {
                    error['msg_national_id'] = "National Is Required";
                    i++;
                }else if (national_id_file && national_id_file.size > (2 * 1024 * 1024)) {
                    error['msg_national_id'] = "The national id size exceeds 2MB. Please select a smaller national id.";
                    i++;
                } 
            }
            if (cv == '') {
                
            }else if (cv_file && cv_file.size > (2 * 1024 * 1024)) {
                    error['msg_cv'] = "The CV size exceeds 2MB. Please select a smaller cv.";
                    i++;
            } 
		    
            if (!$("#concentcheck").is(':checked')) {
                error['msg_consent'] = "Consent Is Required";
                i++;
            }
            if (!$("#termscheck").is(':checked')) {
                error['msg_agree'] = "Agree Is Required";
                i++;
            }
            if (i < 1) {
                
                var formData = new FormData($('#form_reg')[0]);
                formData.append('country_code', countryData.dialCode);
                formData.append('country_short_code', countryData.iso2.toUpperCase());
                $.ajax({
                    url: "{{ route('do_register') }}",
                    method: 'post',
                    data: formData,
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Prevent jQuery from setting the Content-Type header
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
                            alert(result.message);
                            window.location.href = "{{ route('login') }}";
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
		};	    
	</script>

	<script>
	function getcity(nationality){
	        $.ajax({
                url: '{{ route('getcity') }}',
                method: 'post',
                data: {
                    'nationality': nationality
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                beforeSend: function() {
                    
                },
                success: function(result) {
                    
                    if (result.status == 1) {
                        $("#city_id").html(result.html);
                    } else {
                        
                    }

                }
            });
	}
		$(document).ready(function(){
			$('.ptw-wrap, .ed-wrap, .el-wrap, .hl-wrap').hide();

			$('input[name="nationality"]').on('change', function(){
				const nationality = $(this).siblings('span').text().trim();
                
                if(nationality === "Irish")
                {
                    $('.ptw-wrap, .ed-wrap, .el-wrap, .hl-wrap').hide();
					$('.ni-wrap').show();    
                }else if(nationality === "EU")
                {
                    $('.el-wrap, .hl-wrap').show();
					$('.ni-wrap').show(); 
					$('.ptw-wrap').hide(); 
					$('.ed-wrap').hide(); 
                }else if(nationality === "Non-EU"){
                    $('.ptw-wrap, .ed-wrap, .el-wrap, .hl-wrap').show();
					$('.ni-wrap').hide(); 
                }
				getcity(nationality);
			});

		});		
	</script>
</body>
</html>