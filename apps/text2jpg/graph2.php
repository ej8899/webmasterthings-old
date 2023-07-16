<? 
//	adapted from italian graphitti at www.snark.it
//
// requires both the GD library 1.6 and above and the FreeType library
//
//

// call via <IMG SRC="http://www.webmasterthings.com/apps/text2jpg/graph2.php?text=TEXTGOESHERE" border=0>


header( "Content-type: image/png");
srand((double)microtime()*1000000);


// grab a random font
$rando=rand(1,5);
switch ($rando) {
       case 1:
           $font= "/mnt2/users/c00585/ejohnson/webmasterthings.com/html/apps/text2jpg/kidsn.ttf";
           break;
       case 2:
           $font= "/mnt2/users/c00585/ejohnson/webmasterthings.com/html/apps/text2jpg/cosmicn.ttf";
           break;
       case 3:
           $font= "/mnt2/users/c00585/ejohnson/webmasterthings.com/html/apps/text2jpg/baratzb.ttf";
           break;
       case 4:
           $font= "/mnt2/users/c00585/ejohnson/webmasterthings.com/html/apps/text2jpg/carlisl.ttf";
           break;
		case 5:
			$font="/mnt2/users/c00585/ejohnson/webmasterthings.com/html/apps/text2jpg/arial.ttf";
			break;
   }
   

//	select a font size (?)
$rando=rand(1,4);
switch ($rando) {
       case 1:
           $dimensioneCarattere = 15;
           break;
       case 2:
           $dimensioneCarattere = 18;
           break;
       case 3:
           $dimensioneCarattere = 21;
           break;
       case 4:
           $dimensioneCarattere = 24;
           break;
   }

$angoloCarattere = rand(-2,2);
$fontfile =  "$font";
echo "|$font|";
//
// generate the image
//
$text=StripSlashes($text);
$dimtxt = ImageTTFBBox( $dimensioneCarattere, $angoloCarattere, $fontfile, $text );
$bordo = 20;

$txtsizex = abs($dimtxt[2] - $dimtxt[0]);
$txtsizey = abs($dimtxt[5] - $dimtxt[3]);

$imgsizex = $txtsizex + 3*$bordo;
$imgsizey = $txtsizey + 5*$bordo;

$posXtesto = $bordo;
$posYtesto = $txtsizey + $bordo;


$img = imageCreate( $imgsizex, $imgsizey);

$transp = imagecolorallocate( $img, 255, 255, 255);


$rando=rand(1,4);
switch ($rando) {
       case 1:
           $colore = imagecolorallocate( $img, 0, 0, 0);
           break;
       case 2:
           $colore = imagecolorallocate( $img, 32, 134, 68);
           break;
       case 3:
           $colore = imagecolorallocate( $img, 0, 0, 255);
           break;
       case 4:
           $colore = imagecolorallocate( $img, 255, 0, 0);
           break;
   }
   
imagefill( $img, 0, 0, $transp);
imageTTFText( $img, $dimensioneCarattere, $angoloCarattere, $posXtesto, $posYtesto, $colore,$fontfile, $text );


// set the transparent color
imagecolortransparent( $img, $transp); 

// set a temp filename
$nomefile="img".time().rand(1,100);
imagepng( $img );
imagedestroy( $img );


?> 

