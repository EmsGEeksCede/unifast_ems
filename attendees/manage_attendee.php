<?php include '../admin/db_connect.php' ?>
<?php
$sql = mysqli_query($conn, "SELECT DISTINCT(hei_region_nir) FROM tbl_heis ORDER BY hei_region_nir ASC");
?>
<?php
$result = mysqli_query($conn, "SELECT hei_name FROM tbl_heis");
?>
<div class="d-flex justify-content-center col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" method="post" id="manage_attendee">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="form-row align-items-center">
					<div class="form-group col-md-4">
						<!-- <label for="" class="control-label text-muted">HEI Region</label> -->
						<select name="hei_region" id="" class="form-control" required>
							<option value="" disabled selected>- - - Select Region - - -</option>
							<?php
							while ($row = mysqli_fetch_array($sql)) :
							?>
								<option><?php echo $row['hei_region_nir'] ?></option>
							<?php endwhile;	?>
						</select>
					</div>
					<div class="form-group col-md-8">
						<!-- <label for="" class="control-label text-muted">HEI Name</label> -->
						<!-- <input type="text" name="hei_name" list="heiname" autocomplete="off" class="form-control" required placeholder="HEI Name"> -->

						<select name="hei_name" class="custom-select select2">
							<option value=""></option>
							<?php
							while ($row = mysqli_fetch_array($result)) :
							?>
								<option value="<?php echo $row['hei_name']; ?>">
									<?= $row['hei_name']?></option>
							<?php endwhile; ?>
						</select>

						<!-- <datalist id="heiname">
							<?php
							// while ($row = mysqli_fetch_array($result)) :
							?>
								<option value="<?php // echo $row['hei_name']; 
												?>"><? //= $row['hei_name'] 
													?></option>
							<?php //endwhile; 
							?>
						</datalist> -->
					</div>
				</div>

				<b class="text-muted">Full Name</b>
				<div class="form-row align-items-center">
					<div class="form-group col-md-4">
						<input type="text" name="firstname" class="form-control" required value="<?php echo isset($firstname) ? $firstname : '' ?>" placeholder="First Name">
					</div>

					<div class="form-group col-md-4">
						<input type="text" name="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename : '' ?>" placeholder="Middle Name">
					</div>

					<div class="form-group col-md-4">
						<input type="text" name="lastname" class="form-control" required value="<?php echo isset($lastname) ? $lastname : '' ?>" placeholder="Last Name">
					</div>
				</div>

				<div class="form-row align-items-center">
					<div class="form-group col-md-6">
						<b class="text-muted">Position</b>
						<input type="text" name="position" class="form-control" required value="<?php echo isset($position) ? $position : '' ?>" placeholder="Position">
					</div>

					<div class="form-group col-md-4">
						<b class="text-muted">Contact</b>
						<input type="number" name="contact" class="form-control" required placeholder="Ex.09xxxxxxx" value="<?php echo isset($contact) ? $contact : '' ?>">
					</div>

					<div class="form-group col-md-2">
						<b class="text-muted">Gender</b>
						<select name="gender" id="" class="form-control" required>
							<option value="" disabled selected>Gender</option>
							<option <?php echo isset($gender) && $gender == "Male" ? "selected" : '' ?>>Male</option>
							<option <?php echo isset($gender) && $gender == "Female" ? "selected" : '' ?>>Female</option>
						</select>
					</div>
				</div>

				<!-- <b class="text-muted">System Credentials</b>
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
				</div> -->

				<!-- <div class="form-group">
					<label for="" class="control-label">Attendance Status</label>
					<input type="checkbox" name="status" id="" data-bootstrap-switch data-toggle="toggle" data-on="Present" data-off="Waiting" class="switch-toggle status" data-size="xs" data-onstyle="success" data-offstyle="danger" data-width="5rem" <?php //echo isset($status) && $status == '1' ? 'checked' : ''
																																																															?>>
				</div> -->
				<hr>
				<div class="col-lg-12 text-right d-flex justify-content-end">
					<input class="btn btn-primary btn-large col-lg-2" type="submit" name="submit" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$('.status').bootstrapToggle()
	$('#manage_attendee').on('submit', function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: '../admin/ajax.php?action=save_attendee_info',
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
						location.reload()
					}, 750)
				}
			}
		})
	})

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