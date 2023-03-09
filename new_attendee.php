<?php include 'admin/db_connect.php' ?>
<?php 
$event = $conn->query("SELECT * FROM tbl_events where md5(id) = '{$_GET['c']}'")->fetch_array();
foreach($event as $k => $v){
	$$k = $v;}
?>
<?php
if(!isset($conn))
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM attendees where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;}}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Registration | PHP</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="content-header">
      <div class="container-md">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo ucwords($event)." Event" ?></h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
            <hr class="border-primary">
      </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
	<form action="" method="post" id="new_attendee">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<input type="hidden" name="event_id" value="<?php echo isset($_GET['event_id']) ? $_GET['event_id'] : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label text-muted">HEI Name</label>
							<input type="text" name="hei_name" class="form-control form-control-sm" required value="<?php echo isset($hei_name) ? $hei_name : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label text-muted">HEI Region</label>
							<select name="hei_region" id="" class="custom-select custom-select-sm">
								<option></option>
								<option <?php echo isset($hei_region) && $hei_region == "NCR" ? "selected" : '' ?>>NCR</option>
								<option <?php echo isset($hei_region) && $hei_region == "CAR" ? "selected" : '' ?>>CAR</option>
								<option <?php echo isset($hei_region) && $hei_region == "CARAGA" ? "selected" : '' ?>>CARAGA</option>
								<option <?php echo isset($hei_region) && $hei_region == "BARMM" ? "selected" : '' ?>>BARMM</option>
								<option <?php echo isset($hei_region) && $hei_region == "MIMAROPA" ? "selected" : '' ?>>MIMAROPA</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 1" ? "selected" : '' ?>>Region 1</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 2" ? "selected" : '' ?>>Region 2</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 3" ? "selected" : '' ?>>Region 3</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 4" ? "selected" : '' ?>>Region 4</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 5" ? "selected" : '' ?>>Region 5</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 6" ? "selected" : '' ?>>Region 6</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 7" ? "selected" : '' ?>>Region 7</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 8" ? "selected" : '' ?>>Region 8</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 9" ? "selected" : '' ?>>Region 9</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 10" ? "selected" : '' ?>>Region 10</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 11" ? "selected" : '' ?>>Region 11</option>
								<option <?php echo isset($hei_region) && $hei_region == "Region 12" ? "selected" : '' ?>>Region 12</option>
							</select>
						</div>
						<b class="text-muted">Gender</b>
						<div class="form-group">
							<input type="number" name="contact" class="form-control form-control-sm" required placeholder="Eg. 09-------------" value="<?php echo isset($contact) ? $contact : '' ?>">
						</div>
						<b class="text-muted">Email</b>
						<div class="form-group">
							<input type="email" name="email" class="form-control form-control-sm" required placeholder="Eg. juandelacruz@gmail.com" value="<?php echo isset($email) ? $email : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<b class="text-muted">Attendee's Information</b>
						<div class="form-group">
							<input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? $firstname : '' ?>" placeholder="Firstname">
						</div>
						<div class="form-group">
							<input type="text" name="middlename" class="form-control form-control-sm"  value="<?php echo isset($middlename) ? $middlename : '' ?>" placeholder="Middlename">
						</div>
						<div class="form-group">
							<input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? $lastname : '' ?>" placeholder="Lastname">
						</div>
						<b class="text-muted">Position</b>
						<div class="form-group">
							<input type="text" name="position" class="form-control form-control-sm" required value="<?php echo isset($position) ? $position : '' ?>">
						</div>
						<b class="text-muted">Gender</b>
						<div class="form-group">
							<select name="gender" id="" class="custom-select custom-select-sm">
								<option></option>
								<option <?php echo isset($gender) && $gender == "Male" ? "selected" : '' ?>>Male</option>
								<option <?php echo isset($gender) && $gender == "Female" ? "selected" : '' ?>>Female</option>
							</select>
						</div>
					</div>
				</div>
			</form>
</div>
<br>
<div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="">SAVE</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
		<input class="btn btn-primary" type="submit" id="register" name="create" value="Sign Up">
</div>
<style>
	img#cimg{
		max-height: 15vh;
		/*max-width: 6vw;*/
	}
</style>
<script>
	$('.status').bootstrapToggle()
    $('#manage_attendee').submit(function(e){
        e.preventDefault()
		start_load()
        $.ajax({
            url:'admin/ajax.php?action=save_attendee',
            data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
            success:function(resp){}
        })
    })
</script>
</body>
</html>