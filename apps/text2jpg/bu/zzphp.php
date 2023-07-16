<?
  Header("Content-type: image/png");
  // usage php2.php?fontsize=12&text=xxxx&shadow=yes&fontname=arial&lightbg=yes
  //  
  // note - must use the absolute font path
  // be careful about blank lines in your code which will output a blank and confuse browser
 if(!$text)
 {
 	 $text = "Dynamic PHP Text";
  }
  if(!$fontsize)
  {
  	$fontsize=12;
	}
	$s=$fontsize;
  if(!$fontname)
  {
  	$fontname='arial';
  }
  

// try this 
$font=realpath("$fontname.ttf");
//  $font = "/mnt2/users/c00585/ejohnson/webmasterthings.com/html/apps/text2jpg/$fontname.ttf";
  if(!isset($s)) $s=24;
  $size = imagettfbbox($s,0,$font,$text);
  $dx = abs($size[2]-$size[0]);
  $dy = abs($size[5]-$size[3]);
  $xpad=19;
  $ypad=19;
  $im = imagecreate($dx+$xpad,$dy+$ypad);





  
if($lightbg)  { 	
if($xbg){
	$xpbg=ImageColorAllocateHEX($im,$xbg);
	$trans=imagecolortransparent($im,$xpbg);}
else
{
$white = ImageColorAllocate($im, 255,255,255);
}
$black = ImageColorAllocate($im, 0,0,0);
$trans=  imagecolortransparent ( $im,$white);  }
else  { 	
if($xbg){
	$xpbg=ImageColorAllocateHEX($im,$xbg);
	$trans=imagecolortransparent($im,$xpbg);}
else
{
$black = ImageColorAllocate($im, 0,0,0);
}
$white = ImageColorAllocate($im, 255,255,255);
$trans=  imagecolortransparent ( $im,$black);  }


// define font primary colors
$blue=ImageColorAllocate($im,0x2C,0x6D,0xAF);
$orange=ImageColorAllocate($im,242,116,4);

if(!$fontcolor) {	$thefontcolor=$blue; }
if($fontcolor=="orange"){	$thefontcolor=$orange; }  


 //ImageRectangle($im,0,0,$dx+$xpad,$dy+$ypad,$blue);
  
  if($shadow==yes && $lightbg==yes){
  	ImageTTFText($im, $s, 0, (int)($xpad/2)+1, $dy+(int)($ypad/2), $black, "$font", $text);
  }
  if($shadow==yes && !$lightbg){
  	ImageTTFText($im, $s, 0, (int)($xpad/2)+1, $dy+(int)($ypad/2), $white, "$font", $text);
  }
  
  ImageTTFText($im, $s, 0, (int)($xpad/2), $dy+(int)($ypad/2)-1, $thefontcolor, "$font", "$text");
  Imagepng($im);
  ImageDestroy($im);
  
  
  
 // setup image color with regular hex value ie #ff0010
function ImageColorAllocateHEX($im,$s){
    if ($s[0]=="#") $s=substr($s,1);
    $bg_dec=hexdec($s);
    return imagecolorallocate($im,
                ($bg_dec & 0xFF0000) >> 16,
                ($bg_dec & 0x00FF00) >>  8,
                ($bg_dec & 0x0000FF)
                );
}
  
?> 