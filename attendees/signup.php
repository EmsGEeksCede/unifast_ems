<!DOCTYPE html>
<html lang="en">
<?php include 'header.php' ?>
<?php include '../admin/db_connect.php' ?>
<?php
$sql = mysqli_query($conn, "SELECT DISTINCT(hei_region_nir) FROM tbl_heis ORDER BY hei_region_nir ASC");
?>
<?php
$result = mysqli_query($conn, "SELECT hei_uii,hei_name FROM tbl_heis");
// $result = mysqli_query($conn, "SELECT tbl_heis.hei_uii, tbl_heis.hei_name FROM tbl_heis INNER JOIN tbl_user_accounts ON tbl_heis.hei_uii = tbl_user_accounts.hei_name");
?>
<!-- /.create-QR -->
<?php
	include '../phpqrcode/qrlib.php';
	if (isset($_POST['item_id'])) {
		//data to be stored in qr
		$item = $_POST['item_id'];

		//file path
		$file = '../qrinfo/qr1.png';

		//other parameters
		$ecc = 'H';
		$pixel_size = 20;
		$frame_size = 5;

		// Generates QR Code and Save as PNG
		QRcode::png($item, $file, $ecc, $pixel_size, $frame_size);

		// Displaying the stored QR code if you want
		echo "<center><img src='".$file."'></center>";
	}
	?>
<body class="hold-transition d-flex justify-content-center">
	<div class="login_form col-lg-7">
		<div class="register-logo">
			<a href="#"><b>UniFAST Event Registration</b></a>
		</div>
		<?php session_start() ?>
		<?php include('../admin/db_connect.php'); ?>
		<div class=" col-lg-12">
			<div class="card">
				<div class="card-body register-card-body">
					<form action="" method="post" id="manage_user">
						<input type="hidden" name="item_id" value="<?php echo isset($id) ? $id : '' ?>">
						<div class="form-row align-items-center">
							<div class="form-group col-md-4">
								<b class="text-muted">Region</b>
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
								<b class="text-muted">HEI Name</b>
								<select name="hei_name" class="custom-select select2">
									<option value=""></option>
									<?php
									while ($row = mysqli_fetch_array($result)) :
									?>
										<option value="<?php echo $row['hei_name']; ?>">
											<?= $row['hei_name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>

						<div class="form-row align-items-center">
							<div class="form-group col">
								<b class="text-muted">First Name</b>
								<input type="text" name="firstname" class="form-control" required value="<?php echo isset($firstname) ? $firstname : '' ?>" placeholder="First Name">
							</div>

							<div class="form-group col">
								<b class="text-muted">Middle Name</b>
								<input type="text" name="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename : '' ?>" placeholder="Middle Name">
							</div>

							<div class="form-group col">
								<b class="text-muted">Last Name</b>
								<input type="text" name="lastname" class="form-control" required value="<?php echo isset($lastname) ? $lastname : '' ?>" placeholder="Last Name">
							</div>

							<div class="form-group col-2">
								<b class="text-muted">Suffix</b>
								<input type="text" name="suffix" class="form-control" value="<?php echo isset($suffix) ? $suffix : '' ?>" placeholder="Suffix">
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

						<!-- Hidden value for type of user -->
						<!-- <b class="text-muted">Select User Type</b> -->
						<div class="form-row d-flex align-items-start">
							<select hidden name="type" id="type" class="custom-select">
								<option value="1" <?php // echo isset($type) && $type == 1 ? 'selected' : '' 
													?> hidden></option>
								<option value="2" <?php // echo isset($type) && $type == 2 ? 'selected' : '' 
													?> hidden></option>
								<option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : ''
													?> selected>Attendees</option>
							</select>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<?php if (!isset($id)) : ?>
									<p>Already have an account? <a href="login.php" class="text-center link-info">Sign In</a></p>
								<?php endif; ?>
							</div>
							<!-- /.col -->
							<div class="col-3">
								<button type="submit" class="btn btn-primary btn-block"><?php echo !isset($id) ? 'Register' : 'Update Account'; ?></button>
							</div>
							<!-- /.col -->
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!-- /.style-css -->
	<style>
		body {
			background: #dfe7e9;
		}

		.link-info {
			transition: all 150ms;
		}

		.link-info:hover {
			color: darkslateblue;
			border-bottom: 1px solid lightseagreen;
		}

		.form-control,
		.btn {
			border-radius: 10px;
			outline: none !important;
		}

		.change::-webkit-input-placeholder {
			/* WebKit, Blink, Edge */
			color: red;
		}

		.login_form {
			margin-top: 2%;
			background: #fff;
			padding: 30px;
			box-shadow: 0px 1px 36px 5px rgba(0, 0, 0, 0.28);
			border-radius: 15px 50px;
		}
	</style>
	<!-- /.register-box -->
	<script>
		$('.status').bootstrapToggle()
		$('#manage_user').on('submit', function(e) {
			e.preventDefault()
			start_load()
			$('input').removeClass("border-danger")
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
				url: '../admin/ajax.php?action=save_user',
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
							location.href = 'login.php'
						}, 750)
					} else if (resp == 2) {
						$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
						$('[name="email"]').addClass("border-danger")
						end_load()
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
	<?php include 'footer.php' ?>

</body>

</html>