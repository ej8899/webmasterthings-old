<?php
//
// version 1.1 01-06-02
//
// call via showthumb.php?image=(path to image)&newwidth=(width of new image)&maxheight=(maximumheight) OR &fixedheight=(forced height of image)&t=texttoadd bottom left of image
//

$size = GetImageSize($image); 
$width = $size[0];  $height = $size[1];  $type = $size[2]; 
$scale=$newwidth/$width; // 90 is new width

$newwidth = round($width*$scale); 
$newheight = round($height*$scale); 
if($maxheight)
{
	if($newheight>$maxheight)
		$newheight=$maxheight;
}  
if($fixedheight)
	$newheight=$fixedheight;
	
header ("Content-type: image/jpeg"); 
$src = imagecreatefromjpeg("$image"); 

//$im = imagecreate($newwidth,$newheight); 
$im =  imagecreatetruecolor($newwidth,$newheight); 	// gd 2.0+ support

//imagecopyresized($im,$src,0,0,0,0,$newwidth,$newheight,$width,$height); 
imagecopyresampled($im,$src,0,0,0,0,$newwidth,$newheight,$width,$height); 

if($t)	// add some text - bottom left of image
{
	$mytext=$t;
	$text_color = ImageColorAllocate ($im, 255, 128, 0);
	$mytext = stripslashes($mytext);
	$mytext = ereg_replace("\r\n","\n",$mytext) ;
	// font 2 is smaller but nice, 5 is bigger and nice - 2nd var
	ImageString ($im, 5, 5,$newheight-20, $mytext, $text_color);
}
$quality=50;

if($q) { $quality=$q; }

imagejpeg($im,'',$quality);
imagedestroy($im); 

?>