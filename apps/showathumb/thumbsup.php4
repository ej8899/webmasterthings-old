<?php 
  
 $image = "ihr_bild.gif";   // Bilddatei 
 $scale = 10;               // In Prozent 
  
 $size = GetImageSize($image); 
 $width = $size[0]; 
 $height = $size[1]; 
 $type = $size[2]; 
 $scale = $scale/100; 
 $newwidth = round($width*$scale); 
 $newheight = round($height*$scale); 
  
  
 if ($type == 1) { 
     header ("Content-type: image/gif"); 
     $src = imagecreatefromgif("$image"); 
     $im = imagecreate($newwidth,$newheight); 
     imagecopyresized($im,$src,0,0,0,0,$newwidth,$newheight,$width,$height); 
     imagegif($im); 
     imagedestroy($im); 
  
 } else if ($type == 2) { 
     header ("Content-type: image/jpeg"); 
     $src = imagecreatefromjpeg("$image"); 
     $im = imagecreate($newwidth,$newheight); 
     imagecopyresized($im,$src,0,0,0,0,$newwidth,$newheight,$width,$height); 
     imagejpeg($im); 
     imagedestroy($im); 
  
 } else if ($type == 3) { 
     header ("Content-type: image/png"); 
     $src = imagecreatefrompng("$image"); 
     $im = imagecreate($newwidth,$newheight); 
     imagecopyresized($im,$src,0,0,0,0,$newwidth,$newheight,$width,$height); 
     imagepng($im); 
     imagedestroy($im); 
  
 } else { 
     echo "Dieses Format wird nicht unterstüzt!"; 
 } 
 
?>