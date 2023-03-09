<?php
if (!isset($conn))
	include 'admin/db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM attendees where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>
<?php
include 'admin/db_connect.php';
$sql = mysqli_query($conn, "SELECT DISTINCT(hei_region_nir) FROM tbl_heis ORDER BY hei_region_nir ASC");
?>
<div class="container-fluid">
	<form action="" method="post" id="manage_attendee">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="event_id" value="<?php echo isset($_GET['event_id']) ? $_GET['event_id'] : '' ?>">
		<div class="form-group">
			<label for="" class="control-label text-muted">HEI Region</label>
			<select name="hei_region" id="" class="custom-select">
				<option disabled selected>---Select Region---</option>
				<?php
				while ($row = mysqli_fetch_array($sql)) {
				?>
					<option><?php echo $row['hei_region_nir'] ?></option>
				<?php
				}
				?>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label text-muted">HEI Name</label>
			<input type="text" name="hei_name" class="form-control" required value="<?php echo isset($hei_name) ? $hei_name : '' ?>">
		</div>

		<b class="text-muted">Attendee's Name</b>
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
				<input type="text" name="position" class="form-control" required value="<?php echo isset($position) ? $position : '' ?>">
			</div>

			<div class="form-group col-md-4">
				<b class="text-muted">Contact</b>
				<input type="number" name="contact" class="form-control" required placeholder="Eg. 09-------------" value="<?php echo isset($contact) ? $contact : '' ?>">
			</div>

			<div class="form-group col-md-2">
				<b class="text-muted">Gender</b>
				<select name="gender" id="" class="form-control">
					<option value="" disabled selected>Gender</option>
					<option <?php echo isset($gender) && $gender == "Male" ? "selected" : '' ?>>Male</option>
					<option <?php echo isset($gender) && $gender == "Female" ? "selected" : '' ?>>Female</option>
				</select>
			</div>
		</div>

		<b class="text-muted">Email</b>
		<div class="form-group">
			<input type="email" name="email" class="form-control" required placeholder="Eg. juandelacruz@gmail.com" value="<?php echo isset($email) ? $email : '' ?>">
		</div>

		<!---<div class="form-group">
			<label for="" class="control-label">Attendance Status</label>
			<input type="checkbox" name="status" id="" data-bootstrap-switch data-toggle="toggle" data-on="Present" data-off="Waiting" class="switch-toggle status" data-size="xs" data-onstyle="success" data-offstyle="danger" data-width="5rem" <?php //echo isset($status) && $status == '1' ? 'checked' : '' 
																																																													?>>
		</div> -->
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
	$('.status').bootstrapToggle()
	$('#manage_attendee').on('submit', function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'admin/ajax.php?action=save_attendee',
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
</script>