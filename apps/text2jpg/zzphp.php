<?
Header("Content-type: image/png");
  	// usage php2.php?fontsize=12&text=xxxx&shadow=yes&fontname=arial&lightbg=yes
	// use %20 for spaces in the 'text' var
  
 	//	OPTIONS:
	//	&xbg=setup the background color (send HEX value ie FFFFFF)
	//  &fcolor=setup font color send hex value
	//  &angle=setup an angle (default 0 which is left to right)
	//	&bold=yes (or leave blank)
	//	&shadow=yes -- adds a shadow (color of shadow works w/ lightbg flag)
	//  &xpad= x padding
	//  &ypad= y padding
	
	//  
  	// note - must use the absolute font path
  	// be careful about blank lines in your code which will output a blank and confuse browser
  
#setup defaults
if(!$text)  		{  	$text = "Dynamic PHP Text";   }
if(!$fontsize)  	{	$fontsize=12;	}	$s=$fontsize;
if(!$fontname)		{  	$fontname='arial';  }
if(!$angle)			{	$angle='0';	}
if(!$bold || $bold=='no')	{	$bold=''; }
if(!$xpad)			{ 	$xpad=19; }
if(!$ypad)			{	$ypad=19; }

// try this 
$font=realpath("$fontname.ttf");
if(!isset($s)) $s=24;
$size = imagettfbbox($s,$angle,$font,$text);
$dx = abs($size[2]-$size[0]);
$dy = abs($size[5]-$size[3]);
$im = imagecreate($dx+$xpad,$dy+$ypad);


if($xbg)	// setup our bg color if supplied, otherwise use defaults (old compatibility)
{
	$xpbg=ImageColorAllocateHEX($im,$xbg);
	$trans=imagecolortransparent($im,$xpbg);
}
else
{
	if($lightbg)  
	{ 	
		$white = ImageColorAllocate($im, 255,255,255);
		$black = ImageColorAllocate($im, 0,0,0);
		$trans=  imagecolortransparent ( $im,$white);  
	}
	else  
	{ 	
		$black = ImageColorAllocate($im, 0,0,0);
		$white = ImageColorAllocate($im, 255,255,255);
		$trans=  imagecolortransparent ( $im,$black);  
	}
}

// define font primary colors
$blue=ImageColorAllocate($im,0x2C,0x6D,0xAF);
$orange=ImageColorAllocate($im,242,116,4);

if(!$fontcolor) {	$thefontcolor=$blue; }
if($fontcolor=="orange"){	$thefontcolor=$orange; }  
if($fcolor) { $thefontcolor=ImageColorAllocateHEX($im,$fcolor); }

 
  if($shadow==yes && $lightbg==yes){
  	ImageTTFText($im, $s, $angle, (int)($xpad/2)+1, $dy+(int)($ypad/2), $black, "$font", $text);
  }
  if($shadow==yes && !$lightbg){
  	ImageTTFText($im, $s, $angle, (int)($xpad/2)+1, $dy+(int)($ypad/2), $white, "$font", $text);
  }
  

if($bold)
{ 
	drawboldtext($im, $s, $angle, (int)($xpad/2), $dy+(int)($ypad/2)-1, $thefontcolor, "$font", "$text");
}
else 
{
	ImageTTFText($im, $s, $angle, (int)($xpad/2), $dy+(int)($ypad/2)-1, $thefontcolor, "$font", "$text");
}
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

function drawboldtext($image, $size, $angle, $x_cord, $y_cord, $color, $fontfile, $text)
{
   $_x = array(1, 0, 1, 0, -1, -1, 1, 0, -1);
   $_y = array(0, -1, -1, 0, 0, -1, 1, 1, 1);
   for($n=0;$n<=8;$n++) // 4 was 8
   {
     ImageTTFText($image, $size, $angle, $x_cord+$_x[$n], $y_cord+$_y[$n], $color, $fontfile, $text);
   }
}
  
?> 
