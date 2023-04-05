<?php
include_once '../admin/db_connect.php';
$query = "SELECT * FROM tbl_heis WHERE hei_psg_region = '" . $_POST['hei_psg_region'] . "' ";
$result = $conn->query($query);
?>
<option value="" disabled selected></option>

<?php
while ($row = $result->fetch_assoc()) : ?>
    <option value="<?php echo $row['hei_name'];?>"><?= $row['hei_name'] ?></option>
<?php endwhile;  ?>