<?php
include 'db_connect.php';
$eid = isset($_GET['eid']) ? $_GET['eid'] : '';
if (!empty($eid)) {
	$event = $conn->query("SELECT * FROM tbl_events where id = $eid")->fetch_array();
	foreach ($event as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="col-lg-12">
	<div class="card card-outline card-info">
		<div class="card-header">
			<!-- <b>Attendance</b> -->
			<div class="card-tools">
				<button class="btn btn-success btn-flat" type="button" id="print_record">
					<i class="fa fa-print"></i> Print</button>
			</div>

		</div>
		<div class="card-body">
			<div class="row justify-content-center">
				<label for="" class="mt-2">Event</label>
				<div class="col-sm-4">
					<select name="eid" id="eid" class="custom-select select2">
						<option value=""></option>
						<?php
						$events = $conn->query("SELECT * FROM tbl_events order by event asc");
						while ($row = $events->fetch_assoc()) :
						?>
							<option value="<?php echo $row['id'] ?>" data-cid="<?php echo $row['id'] ?>" <?php echo $eid == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['event']) ?></option>
						<?php endwhile; ?>
					</select>
				</div>
			</div>
			<hr>
			<?php if (empty($eid)) : ?>
				<center> Please select event First.</center>
			<?php else : ?>
				<table class="table table-stripped table-bordered table-hover" id="att-records">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Region</th>
							<th class="text-center">HEI Name</th>
							<th class="text-center">Name of Attendee</th>
							<th class="text-center">Position</th>
							<th class="text-center">Contact</th>
							<th class="text-center">Email</th>
							<th class="text-center">Date/Time</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$attendees = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM attendees where event_id= $eid order by concat(lastname,', ',firstname,' ',middlename) asc ");
						if ($attendees->num_rows > 0) :
							while ($row = $attendees->fetch_assoc()) :

						?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center"><?php echo ucwords($row['hei_region']) ?></td>
									<td class="text-center"><?php echo ucwords($row['hei_name']) ?></td>
									<td class="text-center"><?php echo ucwords($row['name']) ?></td>
									<td class="text-center"><?php echo ucwords($row['position']) ?></td>
									<td class="text-center"><?php echo ucwords($row['contact']) ?></td>
									<td class="text-center"><?php echo $row['email'] ?></td>
									<td class="text-center"><?php echo $row['date_created'] ?></td>
								</tr>
							<?php endwhile; ?>
						<?php else : ?>
							<tr>
								<th colspan="8">
									<center>No Records.</center>
								</th>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			<?php endif; ?>

		</div>
	</div>
</div>
<noscript>
	<style>
		table#att-records {
			width: 100%;
			border-collapse: collapse
		}

		table#att-records td,
		table#att-records th {
			border: 1px solid
		}

		.text-center {
			text-align: center
		}
	</style>
	<h4 class="text-center">Attendance</h4>
	<hr>
	<div>
		<p><b>Event: </b><?php echo isset($event) ? ucwords($event) : '' ?></p>
		<p><b>Venue: </b><?php echo isset($venue) ? ucwords($venue) : '' ?></p>
		<!-- <p><b>Event Description: </b><?//php echo isset($description) ? ucwords($description) : '' ?></p> -->
		<p><b>Event Start: </b><?php echo date("M d, Y h:i A", strtotime($datetime_start)) ?></p>
		<p><b>Event End: </b><?php echo date("M d, Y h:i A", strtotime($datetime_end)) ?></p>
	</div>
</noscript>
<script>
	$(document).ready(function() {
		$('#eid').change(function() {
			location.href = 'index.php?page=attendance&eid=' + $(this).val()
		})

		$('#print_record').click(function() {
			var _c = $('#att-records').clone();
			var ns = $('noscript').clone();
			ns.append(_c)
			var nw = window.open('', '_blank', 'width=900,height=600')
			nw.document.write(ns.html())
			nw.document.close()
			nw.print()
			setTimeout(() => {
				nw.close()
			}, 500);
		})
	})
</script>