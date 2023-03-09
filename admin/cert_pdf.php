<?php include 'db_connect.php' ?>
<?php
$qry = $conn->query("SELECT * FROM attendees");
foreach ($qry as $k => $v) {
    $$k = $v;
}
?>
<?php
// if(isset($_GET['id'])){
// 	$qry = $conn->query("SELECT a.*,concat(a.lastname,', ',a.firstname,' ',a.middlename) as name FROM attendees");
// }
?>
<?php
require('tfpdf/tfpdf.php');
//$name = text to be added, $x= x cordinate, $y = y coordinate, $a = alignment , $f= Font Name, $t = Bold / Italic, $s = Font Size, $r = Red, $g = Green Font color, $b = Blue Font Color
function AddText($pdf, $text, $x, $y, $a, $f, $t, $s, $r, $g, $b)
{
    $pdf->SetFont($f, $t, $s);
    $pdf->SetXY($x, $y);
    $pdf->SetTextColor($r, $g, $b);
    $pdf->Cell(0, 10, $text, 0, 0, $a);
}
// Select data from MySQL database
$select = "SELECT * FROM `attendees` ORDER BY id";
$result = $conn->query($select);
//Create A 4 Landscape page
$pdf = new TFPDF('L', 'mm', 'A5');
function CreatePage($pdf, $name)
{
    $h = 148.5;
    $pdf->AddPage();
    // Add background image for PDF
    $pdf->Image('../assets/uploads/cert.png', 0, 0, 210, $h, "png");
    $fontsize = 32;


    //Add a Name to the certificate
    if (strlen($name) > 24) {
        $fontsize = 22;
    }
    //UTF8 unicode characters
    $pdf->AddFont('GOTHIC', '', 'GOTHIC.ttf', true);
    $pdf->AddFont('GOTHIC', 'B', 'GOTHICB0.ttf', true);
    AddText($pdf, ucwords($name), 10, 70, 'C', 'GOTHIC', 'B', $fontsize, 10, 84, 156);
}
CreatePage($pdf, 'José Protacio Rizal Mercado y Alonso Realonda');
CreatePage($pdf, 'Robert Dela Cruz');

function Event($pdfevent, $event)
{
    $eventfontsize = 14;

    //Add a Name to the certificate
    if (strlen($event) > 24) {
        $eventfontsize = 14;
    }
    //UTF8 unicode characters
    $pdfevent->AddFont('GOTHIC', '', 'GOTHIC.ttf', true);
    $pdfevent->AddFont('GOTHIC', 'B', 'GOTHICB0.ttf', true);
    AddText($pdfevent, ucwords($event), 10, 88.8, 'C', 'GOTHIC', '', $eventfontsize, 0, 0, 0);
}

Event($pdf, 'José Protacio Rizal');

$filename = "EVENTCertificate.pdf";
$pdf->Output($filename, 'I');
?>