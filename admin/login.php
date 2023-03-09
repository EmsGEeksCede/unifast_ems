<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('./db_connect.php');
?>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Admin Login | UniFAST Event Management System</title>


	<?php include('./header.php'); ?>
	<?php
	if (isset($_SESSION['login_id']))
		header("location:index.php?page=home");

	?>

</head>
<style>
	body {
		width: 100%;
		height: calc(100%);
		position: fixed;
		top: 0;
		left: 0
			/*background: #007bff;*/
	}

	main#main {
		width: 100%;
		height: calc(100%);
		display: flex;
	}
</style>

<body class="bg-dark">


	<main id="main">

		<div class="align-self-center w-100">
			<div id="login-center" class="bg-dark row justify-content-center">
				<div class="card col-md-3">
					<!-- <div class="card-body login-card-body"> -->
					<div class="card-body">
						<div class="text-center">
							<img class="img-fluid " src="../assets/uploads/UnifastLogo.png" width="40%" height="40%">
						</div>
						<div class="form-group">
							<h4 class="text-dark text-center">Event Management System</h4>
						</div>
						<form id="login-form">
							<!-- <label for="email" class="control-label text-dark">Username</label> -->
							<div class="input-group mb-3">
								<input type="text" id="email" name="email" class="form-control" autofocus required placeholder="Username">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas bi-person"></span>
									</div>
								</div>
							</div>

							<!-- <label for="password" class="control-label text-dark">Password</label> -->
							<div class="input-group mb-3">
								<input type="password" id="password" class="form-control" name="password" required placeholder="Password">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="bi bi-eye-slash" id="togglePassword"></span>
									</div>
								</div>
							</div>


							<center>
								<button class="btn-sm btn-block btn-wave col-md-6 btn-primary">LOGIN</button>
							</center>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>

	<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e) {
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'ajax.php?action=login',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success: function(resp) {
				if (resp == 1) {
					location.href = 'index.php?page=home';
				} else {
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
	$('.number').on('input keyup keypress', function() {
		var val = $(this).val()
		val = val.replace(/[^0-9 \,]/, '');
		val = val.toLocaleString('en-US')
		$(this).val(val)
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
</script>

</html>