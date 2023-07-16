<?php

$size = GetImageSize($image); 
$width = $size[0];  $height = $size[1];  $type = $size[2]; 
$scale=$newwidth/$width; // 90 is new width

$newwidth = round($width*$scale); 
$newheight = round($height*$scale); 
  
header ("Content-type: image/jpeg"); 
$src = imagecreatefromjpeg("$image"); 
$im = imagecreate($newwidth,$newheight); 
imagecopyresized($im,$src,0,0,0,0,$newwidth,$newheight,$width,$height); 
imagejpeg($im); 
imagedestroy($im); 

 ?>