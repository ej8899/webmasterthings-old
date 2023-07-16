<?PHP
$i_width  = 200;
$i_height = 40;

$string = "Hello World!";
$pointsize = 20;
$fontfile = "/mnt2/users/c00585/ejohnson/webmasterthings.com/html/apps/text2jpg/cosmicn.ttf";

$im = imagecreate($i_width, $i_height);
$black = imagecolorallocate ($im, 0, 0, 0);
$white = imagecolorallocate ($im, 255, 255, 255);

$string_size = ImageFtBbox($pointsize, 0, $fontfile, $string, array("linespacing" => 1));
$s_width  = $string_size[4];
$s_height = $string_size[5];

ImageFtText($im, $pointsize, 0, $i_width - $s_width - 1,  0 - $s_height, $white, $fontfile, $string, array("linespacing" => 1));

Header ("Content-type: image/png");
ImagePNG ($im);
ImageDestroy ($im);
?>