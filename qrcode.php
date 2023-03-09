
<?php
 require_once 'phpqrcode/qrlib.php';

 $input = "1"; 
 $path = 'qrinfo/';
 
 $file = $path.$input.".png";
 
//  QRcode::png($input, $file, 'H', 4, 1);
//png, input, file, ECC_LEVEL (L,M,Q,H), pixel size, frame size

// echo "<img src='".$file."'>";
  
// $ecc stores error correction capability('L')
$ecc = 'H';
$pixel_Size = 5;
$frame_Size = 5;
  
// Generates QR Code and Stores it in directory given
QRcode::png($input, $file, $ecc, $pixel_Size, $frame_Size);
  
// Displaying the stored QR code from directory
echo "<center><img src='".$file."'></center>";

?>
            
    
