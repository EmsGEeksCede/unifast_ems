<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_event"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-responsive table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="25%">
					<col width="20%">
					<col width="25%">
					<col width="5%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<!-- <th>Schedule</th> -->
						<th>Event</th>
						<th>Event Venue</th>
						<th>Details</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM tbl_events order by unix_timestamp(datetime_end) desc ");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td><?php echo ucwords($row['event']) ?></td>
							<td><?php echo ucwords($row['venue']) ?></td>
							<td>
								<small><b>Event Start:</b> <?php echo date("M d Y h:i A", strtotime($row['datetime_start'])) ?></small><br>
								<small><b>Event End:</b> <?php echo date("M d Y h:i A", strtotime($row['datetime_end'])) ?></small>
							</td>

							<td class="text-center">
								<?php
								if (strtotime($row['datetime_start']) > time()) :
								?>
									<span class="badge badge-secondary">Pending</span>
								<?php elseif (strtotime($row['datetime_end']) <= time()) :
								?>
									<span class="badge badge-success">Done</span>
								<?php elseif ((strtotime($row['datetime_start']) < time()) && (strtotime($row['datetime_end']) > time())) :
								?>
									<span class="badge badge-warning">On-Going</span>
								<?php endif;
								?>
							</td>

							<td class="text-center">
								<div class="btn-group">
									<a href="./index.php?page=edit_event&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat" data-toggle="tooltip" data-placement="top" title="Edit">
										<i class="fas fa-edit"></i>
									</a>&nbsp;
									<a href="./index.php?page=view_event&id=<?php echo $row['id'] ?>" class="btn btn-info btn-flat" data-toggle="tooltip" data-placement="top" title="Assign Staff">
										<i class="fas fa-user-edit"></i>
									</a>&nbsp;
									<button type="button" class="btn btn-danger btn-flat delete_event" data-id="<?php echo $row['id'] ?>" data-toggle="tooltip" data-placement="top" title="Remove">
										<i class="fas fa-trash"></i>
									</button>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#list').dataTable()
		$('.delete_event').click(function() {
			_conf("Are you sure to delete this event?", "delete_event", [$(this).attr('data-id')])
		})

		// $('.status_chk').change(function() {
		// 	var status = $(this).prop('checked') == true ? 1 : 2;
		// 	if ($(this).attr('data-state-stats') !== undefined && $(this).attr('data-state-stats') == 'error') {
		// 		$(this).removeAttr('data-state-stats')
		// 		return false;
		// 	}
		// 	// return false;
		// 	var id = $(this).attr('data-id');
		// 	start_load()
		// 	$.ajax({
		// 		url: 'ajax.php?action=update_event_stats',
		// 		method: 'POST',
		// 		data: {
		// 			id: id,
		// 			status: status
		// 		},
		// 		error: function(err) {
		// 			console.log(err)
		// 			alert_toast("Something went wrong while updating the event's status.", 'error')
		// 			$('#status_chk').attr('data-state-stats', 'error').bootstrapToggle('toggle')
		// 			end_load()
		// 		},
		// 		success: function(resp) {
		// 			if (resp == 1) {
		// 				alert_toast("Event status successfully updated.", 'success')
		// 				end_load()
		// 			} else {
		// 				alert_toast("Something went wrong while updating the event's status.", 'error')
		// 				$('#status_chk').attr('data-state-stats', 'error').bootstrapToggle('toggle')
		// 				end_load()
		// 			}
		// 		}
		// 	})
		// })
	})

	function delete_event($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_event',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>