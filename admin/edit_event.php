<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM tbl_events where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'update_event.php';
?>