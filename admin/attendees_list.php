<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_attendees_account"><i class="fa fa-plus"></i> Add New User</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table table-hover table-responsive table-bordered" id="list">
				<colgroup>
					<col width="2%">
					<col width="3%">
					<col width="20%">
					<col width="20%">
					<col width="7%">
					<col width="10%">
					<col width="5%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Region</th>
						<th class="text-center">HEI Name</th>
						<th class="text-center">Name</th>
						<th class="text-center">Contact</th>
						<th class="text-center">Email</th>
						<th class="text-center">Gender</th>
						<!-- <th class="text-center">User Type</th> -->
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$type = array('', "Admin", "Staff", "Attendees");
					if ($_GET['page'] == 'attendees_list') {
						$qry = $conn->query("SELECT *,concat(firstname,' ',lastname,' ',suffix) as name FROM tbl_user_accounts WHERE type = 3 order by concat(firstname,' ',middlename,' ',lastname,' ',suffix) asc");
					} else {
						$qry = $conn->query("SELECT *,concat(firstname,' ',lastname,' ',suffix) as name FROM tbl_user_accounts order by concat(firstname,' ',middlename,' ',lastname,' ',suffix) asc");
					}
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><?php echo ucwords($row['hei_region']) ?></td>
							<td><?php echo ucwords($row['hei_name']) ?></td>
							<td><?php echo ucwords($row['name']) ?><!--<span><a href="javascript:void(0)" class="view_data" data-id="<?php echo $row['id'] ?>"><span class="fa fa-qrcode"></span></a></span>--></td>
							<td><?php echo ucwords($row['contact']) ?></td>
							<td><?php echo $row['email'] ?></td>
							<td class="text-center"><?php echo ucwords($row['gender']) ?></td>
							<!-- <td><b><?//php echo $type[$row['type']] ?></b></td> -->
							<td class="text-center">
								<div class="btn-group">
									<a href="./index.php?page=edit_attendees_account&id=<?php echo $row['id'] ?>">
										<button href="button" class="btn btn-primary btn-flat">
											<i class="fas fa-edit"></i>
										</button>
									</a>&nbsp;
									<button href="button" class="btn btn-info btn-flat view_user" data-id="<?php echo $row['id'] ?>">
										<i class="fas fa-eye"></i>
									</button>&nbsp;
									<button type="button" class="btn btn-danger btn-flat delete_user" data-id="<?php echo $row['id'] ?>">
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
		$('.view_user').click(function() {
			uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id=" + $(this).attr('data-id'))
		})
		// $('.view_data').click(function(){
		// 	uni_modal("QR","./admin/view.php?id="+$(this).attr('data-id'))
		// })
		$('.delete_user').click(function() {
			_conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')])
		})
	})

	function delete_user($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_user',
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