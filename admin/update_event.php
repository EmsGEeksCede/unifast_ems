<?php if (!isset($conn)) {
	include 'db_connect.php';
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		$qry = $conn->query("SELECT * FROM tbl_events where id = {$_GET['id']}");
		foreach ($qry->fetch_array() as $k => $v) {
			if (!is_numeric($k)) {
				$$k = $v;
			}
		}
	}
} ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-event">

				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="event" class="control-label">Event</label>
							<input type="text" class="form-control form-control-md" name="event" required value="<?php echo isset($event) ? $event : '' ?>">
						</div>
					</div>
					<!-- <div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Event Schedule</label>
							<input type="datetime-local" class="form-control form-control-sm" name="datetime_end" id="datetime_end" value="<? //php echo isset($datetime_end) ? date("Y-m-d\\TH:i", strtotime($datetime_end)) : '' 
																																			?>" required>
						</div>
					</div> -->


					<div class="col-md-3">
						<div class="form-group">
							<label for="datetime_start" class="control-label">Event Start</label>
							<input type="datetime-local" class="form-control form-control-md" name="datetime_start" id="datetime_start" value="<?php echo isset($datetime_start) ? date("Y-m-d\\TH:i", strtotime($datetime_start)) : '' ?>" required>
						</div>
					</div>

					
					<div class="col-md-3">
						<div class="form-group">
							<label for="datetime_end" class="control-label">Event End</label>
							<input type="datetime-local" class="form-control form-control-md" name="datetime_end" id="datetime_end" value="<?php echo isset($datetime_end) ? date("Y-m-d\\TH:i", strtotime($datetime_end)) : '' ?>" required>
						</div>
					</div>

				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Venue</label>
							<input type="text" class="form-control form-control-md" name="venue" required value="<?php echo isset($venue) ? $venue : '' ?>">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Description</label>
							<textarea type="text" class="form-control form-control-lg" name="description" id=""><?php echo isset($description) ? $description : '' ?></textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="card-footer border-top border-info">
			<div class="d-flex w-100 justify-content-center align-items-center">
				<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-event">Save</button>
				<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=event_list'">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script>
	$('#manage-event').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=update_event_stats',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Data successfully saved', "success");
					setTimeout(function() {
						location.href = 'index.php?page=event_list'
					}, 2000)
				}
			}
		})
	})
</script>