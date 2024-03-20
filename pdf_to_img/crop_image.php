<?php 
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

$im = imagecreatefromjpeg('123.jpg');
  
// find the size of image
$size = min(imagesx($im), imagesy($im));
  
// Set the crop image size 
$im2 = imagecrop($im, ['x' => 0, 'y' => 300, 'width' => 566, 'height' => 800]);
if ($im2 !== FALSE) {
    // header("Content-type: image/png");
    // imagepng($im2);
    // imagedestroy($im2);
    writeImage($im2); 
}
imagedestroy($im);

?>