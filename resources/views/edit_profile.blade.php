@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="row">
	<div class="col-12">
		<form id="form_prof" method="post" enctype="multipart/form-data">
			<div class="mb-3">									
				<div class="dropzone" data-input="file1">
					<div class="drop-title">
						<p>Click to upload file</p>
						
						<img src="images/upload.png" class="img-fluid drop-upload">
					</div>
					<input type="file" id="file1" name="profile_picture" hidden>
					<div class="preview">
						<img src="{{ asset('upload/users/'.$data->profile_picture) }}" class="img-fluid default-preview">
					</div>
					<img src="{{ asset('asset/images/editdark.png') }}" class="img-fluid epedit">
				</div>
				<p class="text-danger err_msg" id="msg_profile_picture"></p>
				
			</div>							
			<div class="ep-box">
				<div class="row">
					<div class="col-12">
						<p class="ep-box-label">Personal Details</p>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">First Name </label>
							<input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name" value="<?php echo $data['first_name']; ?>">
							<p class="text-danger err_msg" id="msg_first_name"></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Last Name </label>
							<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter last name" value="<?php echo $data['last_name']; ?>">
							<p class="text-danger err_msg" id="msg_last_name"></p>
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-12">
						<div class="mb-3">
							<label class="form-label">Phone</label>
							<input type="tel" class="form-control" name="phone" placeholder="Enter phone" id="phone" value="<?php echo $data['phone']; ?>">
							<p class="text-danger err_msg" id="msg_phone"></p>
						</div>	
						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php echo $data['email']; ?>" disabled>
							<p class="text-danger err_msg" id="msg_email"></p>
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Gender</label>
							<select class="form-select" aria-label="Default select example" name="gender" id="gender">
								<option value="">Select Gender</option>
								<option value="Male" <?php if($data['gender']=='Male'){ ?> selected <?php } ?>>Male</option>
								<option value="Female" <?php if($data['gender']=='Female'){ ?> selected <?php } ?>>Female</option>
								<option value="Prefer not to say" <?php if($data['gender']=='Prefer not to say'){ ?> selected <?php } ?>>Prefer not to say</option>
							</select>
							<p class="text-danger err_msg" id="msg_gender"></p> 
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="mb-3">
							<label class="form-label">Date of birth</label>
							<input type="date" class="form-control" id="birth_date" name="birth_date" max="<?php echo date('Y-m-d'); ?>" placeholder="Enter Date of birth" value="<?php echo $data['birth_date']; ?>">
							<p class="text-danger err_msg" id="msg_birth_date"></p> 
						</div>
					</div>
				</div>														
			</div>
			<div class="ep-box">
				<div class="row">
					<div class="col-12">
						<p class="ep-box-label">Work Details</p>
					</div>

					<div class="mb-3">
						<label class="form-label">Where are you currently based?<sup class="text-danger">*</sup></label>
						<select class="form-select" id="city_id" name="city_id">
							<option value="">Select city</option>
							<?php foreach($city_data as $key=>$val){ ?>
							    <option value="<?php echo $val['id']; ?>" <?php if($data['city_id']==$val['id']){ ?> selected <?php } ?>><?php echo $val['name']; ?></option>
							<?php }?>
						</select>
						<p class="text-danger err_msg" id="msg_city_id"></p>
					</div>

					<div class="mb-3">
						<label class="form-label">Do you have experience in Ireland in any of these areas?<sup class="text-danger">*</sup></label>
						<select class="form-select multi-option" style="width: 100%;" multiple="multiple" id="area_experience" name="area_experience[]">
						    <?php foreach($occupations_data as $key=>$val){ ?>
							    <option value="<?php echo $val['id']; ?>" <?php if(in_array($val['id'],$area_experience_arr)){?> selected <?php }?>><?php echo $val['name']; ?></option>
							<?php }?>
						</select>
						<p class="text-danger err_msg" id="msg_area_experience"></p>
					</div>							
 
					<div class="mb-3">
						<label class="form-label">Additional Experience / Skills / Achievements <sup class="text-danger">*</sup></label>
						<textarea class="form-control" id="additional_experience" name="additional_experience" placeholder="Share achievements, certifications, skills..." rows="3"><?php echo $data['additional_experience']; ?></textarea>
						<p class="text-danger err_msg" id="msg_additional_experience"></p>
					</div>
                    <?php if($data['nationality']=='EU' || $data['nationality']=='Non-EU'){ ?>
					<div class="mb-3">
						<label class="form-label">English Level<sup class="text-danger">*</sup></label>
						<select class="form-select" id="english_level" name="english_level">
							<option value="">Select level</option>
							<?php foreach($english_level_data as $key=>$val){ ?>
							    <option value="<?php echo $val['id']; ?>" <?php if($data['english_level_id']==$val['id']){ ?> selected <?php } ?>><?php echo $val['name']; ?></option>
							<?php }?>
						</select>
						<p class="text-danger err_msg" id="msg_english_level"></p>
					</div>
                <?php }?>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-6">
					<a href="{{ route('profile') }}" class="btn btn-secondary ep-cancel-btn d-flex align-items-center justify-content-center" >cancel</a>
				</div>
				<div class="col-6">
					<button type="button" class="btn btn-secondary ubd-save-btn" onClick="do_edit_profile()">save changes</button>								
				</div>
			</div>

		</form>
	</div>
</div>
<div class="loadingClass" id="showload">
    <img src="{{ asset('asset/images/loader.gif') }}" alt="loader" />
</div>
@endsection
@push('custom-style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />	
@endpush
@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
	const input = document.querySelector("#phone");
	const iti =window.intlTelInput(input, {
		initialCountry: "<?php echo $data['country_short_code']; ?>",
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
			if (!file) return;

			preview.innerHTML = "";

			const name = document.createElement("p");
			name.textContent = file.name;
			preview.appendChild(name);

			if (file.type.startsWith("image/")) {
				const reader = new FileReader();
				reader.onload = function(e) {
					const img = document.createElement("img");
					img.src = e.target.result;
					img.classList.add("img-fluid");
					preview.appendChild(img);
				};
				reader.readAsDataURL(file);
			}
		}

	});	
function do_edit_profile(){
    const countryData = iti.getSelectedCountryData();
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var phone = $("#phone").val();
    var gender = $("#gender").val();
    var birth_date = $("#birth_date").val();
    
    var nationality="<?php echo $data['nationality']; ?>";
    var city_id = $("#city_id").val();
    var english_level = $("#english_level").val();
	var area_experience = $("#area_experience").val();
    var additional_experience = $("#additional_experience").val();
    
    
    var profile_picture = $("#file1").val();
    var profile_picture_input = document.getElementById("file1");
    var profile_file = profile_picture_input.files[0];
    
    $(".err_msg").html('');
        
    var error = [];
    var i = 0;

    if (profile_picture == '') {
       
    }else if (profile_file && profile_file.size > (2 * 1024 * 1024)) {
        error['msg_profile_picture'] = "The profile picture size exceeds 2MB. Please select a smaller profile picture.";
        i++;
    }

    if (first_name == '') {
        error['msg_first_name'] = "First Name Is Required";
        i++;
    }
    
    if (last_name == '') {
        error['msg_last_name'] = "Last Name Is Required";
        i++;
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

    if (city_id == '') {
        error['msg_city_id'] = "City Is Required";
        i++;
    }
    if (!area_experience || area_experience.length === 0) {
        error['msg_area_experience'] = "Area Experience Is Required";
        i++;
    }
    /*if (additional_experience == '') {
        error['msg_additional_experience'] = "Additional Experience Is Required";
        i++;
    }*/
    if(nationality=='EU' || nationality=='Non-EU')
    {
        if (english_level == '') {
            error['msg_english_level'] = "English Level Is Required";
            i++;
        }
    }
    if (i < 1) {
        var formData = new FormData($('#form_prof')[0]);
            formData.append('country_code', countryData.dialCode);
            formData.append('country_short_code', countryData.iso2.toUpperCase());
            $.ajax({
                url: "{{ route('do_edit_profile') }}",
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
                        window.location.href = "{{ route('profile') }}";
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