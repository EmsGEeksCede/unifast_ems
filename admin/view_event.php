<?php
include 'db_connect.php';

$qry = $conn->query("SELECT * FROM tbl_events where id = {$_GET['id']}")->fetch_array();
foreach ($qry as $k => $v) {
	$$k = $v;
}
?>

<div class="col-lg-12">
	<div class="row">
		<div class="col-md-8">
			<div class="card card-outline card-info">
				<div class="card-body">
					<div class="">
						<dl class="callout callout-info">
							<dt>Event</dt>
							<dd><?php echo ucwords($event) ?></dd>
						</dl>
						<dl class="callout callout-info">
							<dt>Event Schedule</dt><br>
							<dd><b>Start: </b><?php echo date("M d, Y h:i A", strtotime($datetime_start)) ?></dd>
							<dd><b>End: </b><?php echo date("M d, Y h:i A", strtotime($datetime_end)) ?></dd>
						</dl>
						<dl class="callout callout-info">
							<dt>Venue</dt>
							<dd><?php echo ucwords($venue) ?></dd>
						</dl>
						<dl class="callout callout-info">
							<dt>Description</dt>
							<dd><?php echo html_entity_decode($description) ?></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card card-outline card-warning">
				<div class="card-header">
					<b>Assigned Staff</b>
					<div class="card-tools">
						<button class="btn btn-sm btn-flat btn-default bg-light" id="manage-registrar" type="button">Manage</button>
					</div>
				</div>
				<div class="card-body">
					<ul class="nav flex-column">
						<?php
						$r = $conn->query("SELECT ar.*,concat(u.last_name,', ',u.first_name) as name,u.first_name,u.last_name,u.middle_name FROM assigned_registrar ar inner join tbl_unifast_staff u on u.id = ar.user_id where event_id = {$_GET['id']} order by concat(u.last_name,', ',u.first_name) asc");
						while ($row = $r->fetch_assoc()) :
						?>
							<li class="nav-item text-dark">
								<div class="d-flex align-items-center py-1">
									<span class="brand-image mr-2 img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 30px;height:30px"><b><?php echo strtoupper(substr($row['first_name'], 0, 1) . substr($row['last_name'], 0, 1)) ?></b></span>
									<span><b><?php echo ucwords($row['name']) ?></b></span>
								</div>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#manage-registrar').click(function() {
		uni_modal("Manage Event's Assigned Staff", "manage_registrar.php?id=<?php echo $id ?>");
	})
</script>