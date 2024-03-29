<?php
include('db_connect.php');
session_start();
if (isset($_GET['id'])) {
	$user = $conn->query("SELECT * FROM tbl_unifast_staff where id =" . $_GET['id']);
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>
<div class="container-fluid">
	<div id="msg"></div>

	<form action="" id="manage-user">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
		<div class="form-group">
			<label for="name">First Name</label>
			<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo isset($meta['first_name']) ? $meta['first_name'] : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="name">Middle Name</label>
			<input type="text" name="middle_name" id="middle_name" class="form-control" value="<?php echo isset($meta['middle_name']) ? $meta['middle_name'] : '' ?>">
		</div>
		<div class="form-group">
			<label for="name">Last Name</label>
			<input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo isset($meta['last_name']) ? $meta['last_name'] : '' ?>" required>
		</div>
		<!-- <div class="form-group">
			<label for="username">Email</label>
			<input type="text" name="email" id="email" class="form-control" value="<? //php echo isset($meta['email']) ? $meta['email'] : '' 
																					?>" required autocomplete="off">
		</div> -->
		<div class="form-group">
			<label for="password">Change Password</label>
			<input type="password" name="password" id="password" class="form-control" value="" placeholder="New Password" autocomplete="off">
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		</div>
	</form>
</div>
<style>
	img#cimg {
		max-height: 15vh;
		/*max-width: 6vw;*/
	}
</style>
<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		start_load()
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
					alert_toast("Data successfully saved", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				} else {
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_load()
				}
			}
		})
	})

	$('#manage-user').click(function() {
		var nw = window.open('', '_blank', 'height=600,width800');
		nw.document.write(ccts.html())
		nw.document.close()
		setTimeout(function() {
			window.close()
		}, 750)
	})
	$(document).ready(function() {
		if ($('#uni_modal .modal-header button.close').length <= 0)
			$('#uni_modal .modal-header').append('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
	})
</script>