@extends('layouts.app')
@section('title', 'Upload Document')
@section('content')
<div class="row">
	<div class="col-12">
	    <?php if($data['nationality']=='Non-EU'){?>
	    <?php
		    if($data['permission_to_work1']!='')
		    {
		?>
	    <div class="ud-box">
			<div class="udb-top">
				<p>Work permit (Visa/GNIB)</p>
				
			</div>
			<div class="udb-upload">
				<p></p>
				<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#vdModal">View doc</a>
			</div>
		</div>
		<?php }?>
	    <?php }?>
	    
		<?php if($data['nationality']=='Irish' || $data['nationality']=='EU'){?>
		<?php 
				    if($data['national_id']!='')
				    {
				?>
		<div class="ud-box">
			<div class="udb-top">
				<p>National ID/Passport</p>
				
			</div>
			<div class="udb-upload">
				<p></p>
				<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#vdModal">View doc</a>
			</div>
		</div>
		<?php }?>
	    <?php }?>
	    <?php
		    if($data['cv']!='')
		    {
		?>
		<div class="ud-box">
			<div class="udb-top">
				<p>CV</p>
				
			</div>
			<div class="udb-upload">
				<p></p>
				<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#vdModal">View doc</a>
			</div>
		</div>
		<?php }?>
		<?php
		    if($data['other_relevant_document']!='')
		    {
		?>
		<div class="ud-box">
			<div class="udb-top">
				<p>Other relevant document</p>
				
			</div>
			<div class="udb-upload">
				<p></p>
				<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#vdModal">View doc</a>
			</div>
		</div>
		<?php }?>
		<div class="ud-box">
			<div class="udb-top">
				<p>Terms of Employment</p>
			</div>
			<div class="udb-upload">
			    <p></p>
				<a href="{{ $dataemp['doc'] }}" target="_blank">View doc</a>
			</div>
		</div>		
		<form>
		    <div class="ud-box">
			<div class="mb-3">
				<label class="form-label">PPS number  <a href="javascript:void(0)" class="ps-3" data-bs-toggle="modal" data-bs-target="#psModal"><?php if($data['pps_number']==''){ ?>Add <?php }else{?>Edit<?php }?></a></label>
				<p><?php echo $data['pps_number']; ?></p>
			
			</div>	
			</div>
			<a href="javascript:void(0)" class="und-btn" data-bs-toggle="modal" data-bs-target="#undModal">
				Upload new document
				<img src="{{ asset('asset/images/plus.png') }}" class="img-fluid">
			</a>	
			<?php /*<div class="d-grid mt-3">
				<button type="submit" class="btn btn-primary blue-btn">submit Documents</button>
			</div>*/?>								
		</form>													
	</div>
</div>

<div class="modal fade" id="undModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="undModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="und-top">
				    <div id="showmsg"></div>
					<div>
						<h2>Upload </h2>
						<p>New Document</p>
					</div>
					<a href="javascript:void(0)" data-bs-dismiss="modal">
						<img src="{{ asset('asset/images/close-circle.png') }}" class="img-fluid">
					</a>
				</div>
				<form id="form_doc" method="post" enctype="multipart/form-data">
					<div class="mb-3">
						<label class="form-label">Document Name</label>
						<select class="form-select" id="document_name" name="document_name">
						    <?php  if($data['nationality']=='Non-EU'){?>
							<option value="Work permit">Work permit (Visa/GNIB)</option>
							<?php }else{
							?>
							<option value="National ID">National ID/Passport</option>
							<?php } ?>
							
							
							<option value="CV">CV</option>
							<option value="Other relevant document">Other relevant document</option>
						</select>
						<p class="text-danger err_msg" id="msg_document_name"></p>
					</div>		
					<div class="mb-3">
						<label class="form-label">Upload Documents (CV / ID / Visa)</label>
						<div class="dropzone" data-input="file1">
							<div class="drop-title">
								<p>Click to upload file</p>
								<img src="{{ asset('asset/images/upload.png') }}" class="img-fluid drop-upload">
							</div>
							<input type="file" id="file1" name="document" hidden>
							<div class="preview"></div>
						</div>
						<p class="text-danger err_msg" id="msg_document"></p>
					</div>		
					<div class="d-grid">
						<button type="button" class="btn btn-primary blue-btn" onClick="do_documents()">submit</button>
					</div>																							
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="vdModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="vdModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="und-top">
					<div>
						<h2 class="mb-0">View Document</h2>
					</div>
					<a href="javascript:void(0)" data-bs-dismiss="modal">
						<img src="{{ asset('asset/images/close-circle.png') }}" class="img-fluid">
					</a>
				</div>

				<img src="{{ asset('asset/images/document.jpg') }}" class="img-fluid">
											
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="psModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="psModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="und-top">
				    <div id="showmsg"></div>
					<div>
						<h2></h2>
					</div>
					<a href="javascript:void(0)" data-bs-dismiss="modal">
						<img src="{{ asset('asset/images/close-circle.png') }}" class="img-fluid">
					</a>
				</div>
				<form id="form_doc" method="post" enctype="multipart/form-data">
					<div class="mb-3">
						<label class="form-label">PPS number</label>
						<input type="text" class="form-control" name="pps_number" id="pps_number" placeholder="Enter PPS Number" value="<?php echo $data['pps_number']; ?>">
						<p class="text-danger err_msg" id="msg_pps_number"></p>
					</div>		
						
					<div class="d-grid">
						<button type="button" class="btn btn-primary blue-btn" onClick="do_pps_number()">submit</button>
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
	function do_documents() {
        var document_name = $("#document_name").val();
        var doc = $("#file1").val();
        var doc_input = document.getElementById("file1");
		var doc_file = doc_input.files[0];
         $("#showmsg").html('');
        $(".err_msg").html('');
        
        var error = [];
        var i = 0;

        if (document_name == '') {
            error['msg_document_name'] = "Document Name Is Required";
            i++;
        }
        if (doc == '') {
            error['msg_document'] = "Document Is Required";
            i++;
        }else if (doc_file && doc_file.size > (2 * 1024 * 1024)) {
            error['msg_document'] = "The doc size exceeds 2MB. Please select a smaller doc.";
            i++;
        } 
        
        if (i < 1) {
            
            var formData = new FormData($('#form_doc')[0]);
                
                $.ajax({
                    url: "{{ route('do_document') }}",
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
                            location.reload();
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
<script>
	function do_pps_number() {
        var pps_number = $("#pps_number").val();

        $(".err_msg").html('');
        
        var error = [];
        var i = 0;

        if (pps_number == '') {
            error['msg_pps_number'] = "PPS Number Is Required";
            i++;
        }
        
        if (i < 1) {
            $.ajax({
                url: "{{ route('do_pps_number') }}",
                method: 'post',
                data: {
                    'pps_number': pps_number
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
                        alert(result.message);
                            location.reload();
                    } else {
                        alert(result.message);
                    }

                }
            });
        }else {
            for (var key in error) {
                $('#' + key).html(error[key]);
            }
        }
	}
</script>
@endpush
		