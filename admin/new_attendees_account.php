<?php include 'header.php' ?>
<?php include '../admin/db_connect.php' ?>
<?php
// $sql = mysqli_query($conn, "SELECT DISTINCT(hei_psg_region) FROM tbl_heis ORDER BY hei_psg_region ASC");
// $query = mysqli_query($conn, "SELECT DISTINCT(hei_psg_region) FROM tbl_heis WHERE status = 1 ORDER BY hei_psg_region ASC");
?>
<?php // $result = mysqli_query($conn, "SELECT hei_name FROM tbl_heis");
?>

<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM tbl_user_accounts where id = {$_GET['id']}");
	foreach ($qry->fetch_array() as $k => $v) {
		if (!is_numeric($k)) {
			$$k = $v;
		}
	}
}
?>
<?php
// require_once '../libs/phpqrcode/qrlib.php';
// $path = 'temp/';
// $qrcode = $path . time() . ".png";
// $qrimage = time() . ".png";
// if (isset($_REQUEST['sbt-btn'])) {

// 	$hei_region = $_REQUEST["hei_region"] . "\n";
// 	$hei_name .= $_REQUEST["hei_name"] . "\n";
// 	$firstname .= $_REQUEST["firstname"] . "\n";
// 	$middlename .= $_REQUEST["middlename"] . "\n";
// 	$lastname = $_REQUEST["lastname"] . "\n";
// 	$suffix .= $_REQUEST["suffix"] . "\n";
// 	$position .= $_REQUEST["position"] . "\n";
// 	$contact .= $_REQUEST["contact"] . "\n";
// 	$gender = $_REQUEST["gender"] . "\n";
// 	$email .= $_REQUEST["email"] . "\n";
// 	$password .= $_REQUEST["password"];
// }
// // $qrtext = $_REQUEST['qrtext'];
// $query = mysqli_query($conn, "Insert into qrcode set hei_region='$hei_region', hei_region='$hei_region', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', position='$position', contact='$contact', gender='$gender', email='$email', password='$password', qrimage='$qrimage'");
// if ($query) {
?>
	<!-- <script>
		alert("Data save successfully");
	</script> -->
<?php
// }
// QRcode::png($hei_region, $hei_name, $firstname, $middlename, $lastname, $suffix, $position, $contact, $gender, $email, $password, $qrcode, 'H', 4, 4);
// echo "<img src='" . $qrcode . "'>";
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="qrcode.php" id="manage_user">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

				<div class="form-row align-items-center">
					<div class="form-group col-md-4">
						<b class="text-muted">Region</b>

						<?php
						$query = "SELECT DISTINCT(hei_psg_region) FROM tbl_heis ORDER BY hei_region_nir ASC";
						$result = $conn->query($query);
						?>

						<select name="hei_region" id="hei_region" class="form-control" required>
							<!-- <option value="" disabled selected>- - - Select Region - - -</option>
							<?php
							//while ($row = mysqli_fetch_array($sql)) : 
							?>
								<option><? //php echo $row['hei_psg_region'] 
										?></option>
							<? //php endwhile;	
							?> -->

							<option value="" disabled selected>Select Region</option>
							<?php
							while ($row = mysqli_fetch_array($result)) :  ?>
								<option><?php echo $row["hei_psg_region"]; ?></option>
							<?php endwhile;
							?>
						</select>
					</div>
					<div class="form-group col-md-8">
						<b class="text-muted">HEI Name</b>
						<select name="hei_name" id="hei_name" class="custom-select select2">
							<option value="" id=""></option>
							<!-- <?php
									//while ($row = mysqli_fetch_array($result)) :
									?>
							<option value="<? //php echo $row['hei_name']; 
											?>">
								<//?= $row['hei_name'] 
								?></option>
							<? //php endwhile; 
							?> -->
						</select>
					</div>
				</div>

				<b class="text-muted">Full Name</b>
				<div class="form-row align-items-center">
					<div class="form-group col">
						<input type="text" name="firstname" class="form-control" required value="<?php echo isset($firstname) ? $firstname : '' ?>" placeholder="First Name">
					</div>
					<div class="form-group col">
						<input type="text" name="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename : '' ?>" placeholder="Middle Name">
					</div>
					<div class="form-group col">
						<input type="text" name="lastname" class="form-control" required value="<?php echo isset($lastname) ? $lastname : '' ?>" placeholder="Last Name">
					</div>

					<div class="form-group col-2">
						<input type="text" name="suffix" class="form-control" value="<?php echo isset($suffix) ? $suffix : '' ?>" placeholder="Suffix">
					</div>
				</div>

				<div class="form-row align-items-center">
					<div class="form-group col">
						<b class="text-muted">Designation</b>
						<input type="text" name="position" class="form-control" required value="<?php echo isset($position) ? $position : '' ?>" placeholder="Designation">
					</div>

					<div class="form-group col-4">
						<b class="text-muted">Contact</b>
						<input type="number" name="contact" class="form-control" required placeholder="Ex.09xxxxxxx" value="<?php echo isset($contact) ? $contact : '' ?>">
					</div>

					<div class="form-group col-md-2">
						<b class="text-muted">Gender</b>
						<select name="gender" id="" class="form-control" required>
							<option value="" disabled selected>Please select</option>
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

				<!-- <b class="text-muted">Select User Type</b> -->
				<!-- <div class="form-row d-flex align-items-start"> -->
				<div class="form-group col-md-2">
					<select name="type" id="type" class="custom-select" hidden>
						<option value="1" <?php // echo isset($type) && $type == 1 ? 'selected' : '' 
											?> disabled>User Type</option>
						<option value="2" <?php // echo isset($type) && $type == 2 ? 'selected' : '' 
											?> disabled>Staff</option>
						<option value="3" <?php // echo isset($type) && $type == 3 ? 'selected' : '' 
											?> selected>Attendees</option>
					</select>
				</div>
				<!-- </div> -->


				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<!-- <button class="btn btn-primary mr-3 col-md-2">SAVE</button> -->
					<input type="submit" name="sbt-btn" value="SAVE" class="btn btn-primary mr-3 col-md-2" />
					<button class="btn btn-secondary col-md-2" type="button" onclick="location.href = 'index.php?page=attendees_list'">CANCEL</button>
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
			url: 'ajax.php?action=save_user',
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
						location.replace('index.php?page=attendees_list')
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



	$(document).ready(function() {
		$('#hei_region').on('change', function() {
			var hei_name = $(this).val();
			$.ajax({
				type: 'POST',
				url: 'region_to_hei.php',
				data: 'hei_psg_region=' + hei_name,
				success: function(html) {
					$('#hei_name').html(html);
					// alert(hei);
				}
			});
		});
	});
</script>