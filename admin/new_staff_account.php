<?php
include 'header.php';
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<b class="text-muted">Full Name</b>
				<div class="form-row align-items-center">
					<div class="form-group col-md-4">
						<input type="text" name="first_name" class="form-control" required value="<?php echo isset($first_name) ? $first_name : '' ?>" placeholder="First Name">
					</div>
					<div class="form-group col-md-4">
						<input type="text" name="middle_name" class="form-control" value="<?php echo isset($middle_name) ? $middle_name : '' ?>" placeholder="Middle Name">
					</div>
					<div class="form-group col-md-4">
						<input type="text" name="last_name" class="form-control" required value="<?php echo isset($last_name) ? $last_name : '' ?>" placeholder="Last Name">
					</div>
				</div>
				<!-- <div class="form-group">
							<label for="" class="control-label">Contact No.</label>
							<input type="text" name="contact" class="form-control form-control-sm" required value="<?php  // echo isset($contact) ? $contact : '' 
																													?>">
						</div>
						<div class="form-group">
							<label class="control-label">Address</label>
							<textarea name="address" id="" cols="30" rows="4" class="form-control" required><?php // echo isset($address) ? $address : '' 
																											?></textarea>
						</div> -->
				<!--- <div class="form-group">
							<label for="" class="control-label">Avatar</label>
							<div class="custom-file">
		                      <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
		                      <label class="custom-file-label" for="customFile">Choose file</label>
		                    </div>
						</div>
						<div class="form-group d-flex justify-content-center">
							<img src="<?php // echo isset($avatar) ? '../assets/uploads/'.$avatar :'' 
										?>" alt="" id="cimg" class="img-fluid img-thumbnail">
						</div> --->

				<b class="text-muted">System Credentials</b>
				<div class="form-row d-flex align-items-baseline">
					<div class="form-group col-md-4">
						<input type="email" class="form-control" name="email" required value="<?php echo isset($email) ? $email : '' ?>" placeholder="Email Address">
						<small id="#msg"></small>
					</div>

					<div class="form-group col-md-4">
						<div class="input-group">
							<input type="password" id="password" class="form-control" name="password" <?php echo !isset($id) ? "required" : '' ?> required placeholder="Password">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="bi bi-eye-slash" id="togglePassword"></span>
								</div>
							</div>
						</div>
						<small><i><?php echo isset($id) ? "Leave this blank if you dont want to change you password" : '' ?></i></small>
					</div>

					<div class="form-group col-md-4">
						<div class="input-group">
							<input type="password" id="togcpass" class="form-control" name="cpass" <?php echo !isset($id) ? 'required' : '' ?> required placeholder="Confirm Password">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="bi bi-eye-slash" id="togglecpass"></span>
								</div>
							</div>
						</div>
						<small id="pass_match" data-status=''></small>
					</div>
				</div>

				<!-- <b class="text-muted">Select User Type</b> -->
				<!-- <div class="form-row d-flex align-items-start"> -->
					<!-- <div class="form-group col-sm-2"> -->
						<select name="type" id="type" class="custom-select" hidden>
							<!-- <option value="0" disabled>Select here</option> -->
							<option value="1" <?php // echo isset($type) && $type == 1 ? 'selected' : '' 
												?> disabled>Admin</option>
							<option value="2" <?php // echo isset($type) && $type == 2 ? 'selected' : '' 
												?> selected>Staff</option>
						</select>
					<!-- </div> -->

					<!-- <div class="form-group col-sm-2"> -->
						<select name="status" id="status" class="custom-select" hidden>
							<option value="ACTIVE" <?php echo isset($status) && $status == 'ACTIVE' ? 'selected' : ''
													?> selected>ACTIVE</option>
							<option value="INACTIVE" <?php echo isset($status) && $status == 'INACTIVE' ? 'selected' : ''
														?> disabled>INACTIVE</option>
						</select>
					<!-- </div> -->
				<!-- </div> -->


				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-3	col-md-2">SAVE</button>
					<button class="btn btn-secondary col-md-2" type="button" onclick="location.href = 'index.php?page=staff_list'">CANCEL</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg {
		max-height: 15vh;
		/*max-width: 6vw;*/
	}
</style>
<script>
	$('[name="password"],[name="cpass"]').keyup(function() {
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if (cpass == '' || pass == '') {
			$('#pass_match').attr('data-status', '')
		} else {
			if (cpass == pass) {
				$('#pass_match').attr('data-status', '1').html('<i class="text-success">Password Matched.</i>')
			} else {
				$('#pass_match').attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})

	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#manage_user').submit(function(e) {
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if ($('[name="password"]').val() != '' && $('[name="cpass"]').val() != '') {
			if ($('#pass_match').attr('data-status') != 1) {
				if ($("[name='password']").val() != '') {
					$('[name="password"],[name="cpass"]').addClass("border-danger")
					end_load()
					return false;
				}
			}
		}
		$.ajax({
			url: 'ajax.php?action=save_staff_user',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Data successfully saved.', "success");
					setTimeout(function() {
						location.replace('index.php?page=staff_list')
					}, 750)
				} else if (resp == 2) {
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})

	const togglePassword = document.querySelector("#togglePassword");
	const password = document.querySelector("#password");

	togglePassword.addEventListener('click', function(e) {
		// toggle the type attribute
		const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
		password.setAttribute('type', type);
		// toggle the eye / eye slash icon
		this.classList.toggle('bi-eye');
	});

	const togglecpass = document.querySelector("#togglecpass");
	const togcpass = document.querySelector("#togcpass");

	togglecpass.addEventListener('click', function(e) {
		// toggle the type attribute
		const type = togcpass.getAttribute('type') === 'password' ? 'text' : 'password';
		togcpass.setAttribute('type', type);
		// toggle the eye / eye slash icon
		this.classList.toggle('bi-eye');
	});
</script>