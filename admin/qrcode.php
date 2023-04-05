<?php
require_once '../admin/db_connect.php';
require_once '../libs/phpqrcode/qrlib.php';
$path = 'temp/';
$qrcode = $path.time().".png";
$qrimage = time().".png";

if(isset($_REQUEST['sbt-btn']))
{
$qrtext = $_REQUEST['qrtext'];
$query = mysqli_query($conn,"insert into qrcode set qrtext='$qrtext', qrimage='$qrimage'");
	if($query)
	{
		?>
		<script>
			alert("Data save successfully");
		</script>
		<?php
	}


}

QRcode :: png($qrtext, $qrcode, 'H', 4, 4);
echo "<img src='".$qrcode."'>";
?>