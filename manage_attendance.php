<?php include 'admin/db_connect.php' ?>
<?php
	$event = $conn->query("SELECT * FROM tbl_events where md5(id) = '{$_GET['c']}'")->fetch_array();
	foreach ($event as $k => $v) {
	$$k = $v;
}
?>
	<div class="content-header">
		<div class="container-md">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0"><?php echo ucwords($event) . " Event" ?></h1>
				</div>
			</div>
			<hr class="border-primary">
		</div>
	</div>

	<!-- table for list of attendees -->
	<body onload="startTime()">
		<div class="col-lg-12">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-outline card-primary">
							<div class="card-header">
								<div class="card-tools d-flex justify-content-end" style="width: calc(40%)">
									<button class="btn btn-block btn-sm btn-default btn-flat border-primary col-sm-4 mr-2" href="javascript:void(0)" onclick="location.reload()">
										<i class="fa fa-redo"></i> Refresh List</button>
									<?php if ((strtotime($datetime_start) < time()) && (strtotime($datetime_end) > time())) : ?>
										<button class="btn btn-block btn-sm btn-default btn-flat border-primary new_attendee m-0 col-sm-4" href="javascript:void(0)">
											<i class="fa fa-plus"></i> New Attendee</button>
									<?php endif; ?>
								</div>
								<!-- <div id="clockdate">
									<div class="clockdate-wrapper">
										<div id="clock"></div>
										<div id="date"><?//php echo date('l, F j, Y'); ?></div>
									</div>
								</div> -->
								<span><b>Schedule:</b> <ins><?php echo date("M d, Y h:i A",strtotime($datetime_start)) ?></ins> <i>to</i> <ins><?php echo date("M d, Y h:i A",strtotime($datetime_end)) ?></ins></span>
							</div>
							<div class="card-body">
								<?php if (strtotime($datetime_end) <= time()) : ?>
									<div class="alert alert-danger"><i class="fa fa-info-circle"></i> Event's Registration is now close. </div>
								<?php endif; ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th class="text-center">Region</th>
											<th class="text-center">HEI Name</th>
											<th class="text-center">Name of Attendee</th>
											<th class="text-center">Position</th>
											<th class="text-center">Gender</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1;
										$qry = $conn->query("SELECT a.*,concat(a.lastname,', ',a.firstname,' ',a.middlename) as name,e.event FROM attendees a inner join tbl_events e on e.id = a.event_id where e.id = $id order by unix_timestamp(e.date_created) desc ");
										while ($row = $qry->fetch_assoc()) :
										?>
											<tr>
												<th class="text-center"><?php echo $i++ ?></th>
												<td><b><?php echo ucwords($row['hei_region']) ?></b></td>
												<td><b><?php echo ucwords($row['hei_name']) ?></b></td>
												<td><b><?php echo ucwords($row['name']) ?></b></td>
												<td><b><?php echo ucwords($row['position']) ?></b></td>
												<td><b><?php echo ucwords($row['gender']) ?></b></td>
												<td class="text-center">
													<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action</button>
													<div class="dropdown-menu">
														<a class="dropdown-item edit_attendee" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Edit</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item delete_attendee" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
													</div>
												</td>
											</tr>
										<?php endwhile; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
<script>
	$(document).ready(function() {
		$('.view_attendee').click(function() {
			uni_modal("Attendee Details", "view_attendee.php?id=" + $(this).attr('data-id'))
		})
		$('.new_attendee').click(function() {
			uni_modal("New Attendee", "manage_attendee.php?event_id=<?php echo $id ?>", "modal-lg")
		})
		$('.edit_attendee').click(function() {
			uni_modal("Edit Attendee's Details", "manage_attendee.php?id=" + $(this).attr('data-id') + "&event_id=<?php echo $id ?>", "modal-lg")
		})
		$('.delete_attendee').click(function() {
			_conf("Are you sure to delete this attendee?", "delete_attendee", [$(this).attr('data-id')])
		})

		// $('.status_chk').change(function() {
		// 	var id = $(this).attr('data-id');
		// 	start_load()
		// 	$.ajax({
		// 		url: 'admin/ajax.php?action=update_attendee_stats',
		// 		method: 'POST',
		// 		data: {
		// 			id: id,
		// 			status: status
		// 		},
		// 		success: function(resp) {
		// 			if (resp == 2) {
		// 				alert_toast("Event Registration is close.", 'error')
		// 				_this.attr('data-state-stats', 'error').bootstrapToggle('toggle')
		// 				setTimeout(function() {
		// 					location.reload()
		// 				}, 2000)
		// 			}
		// 		}
		// 	})
		// })
		$('table').dataTable()

	})

	function delete_attendee($id) {
		start_load()
		$.ajax({
			url: 'admin/ajax.php?action=delete_attendee',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1000)

				}
			}
		})
	}

</script>