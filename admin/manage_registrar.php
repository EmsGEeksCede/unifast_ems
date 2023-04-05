<?php include 'db_connect.php' ?>
<?php
// echo "SELECT * FROM assigned_registrar where event_id = {$_GET['id']}";
$qry = $conn->query("SELECT * FROM assigned_registrar where event_id = {$_GET['id']}");
$tbl_unifast_staff = array();
while ($row = $qry->fetch_assoc()) {
	$tbl_unifast_staff[] = $row['user_id'];
}
?>
<div class="container-fluid">
	<form action="" id="ar-frm">
		<input type="hidden" name="event_id" value="<?php echo $_GET['id'] ?>">
		<div class="form-group">
			<label for="">Registrars</label>
			<select name="user_id[]" id="user_id" multiple="multiple" class="custom-select custom-select-sm select2">
				<option value=""></option>
				<?php
				$uqry = $conn->query("SELECT *,concat(last_name,', ',first_name,' ',middle_name) as name FROM tbl_unifast_staff where type != 1 && status = 'ACTIVE' && unit != '-SELECT UNIT-' order by concat(last_name,', ',first_name,' ',middle_name) asc");
				while ($row = $uqry->fetch_assoc()) :
				?>
					<option value="<?php echo $row['id'] ?>" <?php echo count($tbl_unifast_staff) > 0 && in_array($row['id'], $tbl_unifast_staff) ? "selected" : '' ?>><?php echo ucwords($row['last_name']) . ',' . ' ' . ($row['first_name']) . ' ' . substr($row['middle_name'], 0, 1) . '.'?></option>
				<?php endwhile; ?>
			</select>
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {
		$('.select2').select2({
			placeholder: "Please select here.",
			width: "100%"
		})

		$('#ar-frm').submit(function(e) {
			e.preventDefault();
			start_load()
			$.ajax({
				url: 'ajax.php?action=assign_registrar',
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
					}
				}
			})
		})
	})
</script>