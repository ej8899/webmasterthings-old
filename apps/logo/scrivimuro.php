<? 
######################################################################
# Italian Graffiti Creator v 1
# ===========================
#
# Copyright (c) 2000 By Marcello Villani
# email:villani@p2p.it
# Http://www.snark.it
# 
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License.
######################################################################

##### PS: This script requires both the GD library 1.6 and above and the FreeType library.######

################################################################################################
#     You must set muro/ dir in world writable mode (666) and chmod 666 muro.php               #
################################################################################################

################################################################################################
#     Edit the variables below as you like! You can use This script as you like.               #
#                         I'm not responsable about everything!!                               #
#                     (Tradotto: non c'entro nulla con nessun problema!!)                      #
#         Copyright (c) 2000 by Marcello Villani (villani@p2p.it) (http://www.p2p.it)          #
#                                                                                              #
#                                                                                              #
#       This program is free software. You can redistribute it and/or modify                   #
#        it under the terms of the GNU General Public License as published by                  #
#          the Free Software Foundation; either version 2 of the License.                      #
#                                                                                              #
################################################################################################


header( "Content-type: image/png");
srand((double)microtime()*1000000);
$direct = "muro"; // name of the dir
$nomepag = $direct.".php"; //name of the page

$rando=rand(1,4);
switch ($rando) {
       case 1:
           $font= "KIDSN.TTF";
           break;
       case 2:
           $font= "COSMICN.TTF";
           break;
       case 3:
           $font= "BARATZB.TTF";
           break;
       case 4:
           $font= "CARLISL.TTF";
           break;
   }
   


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
$fontfile =  "$direct/$font";


########################## Generating the image ################################################
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


########################## The transparent Color ###############################################

imagecolortransparent( $img, $transp); 

########################That's the casual name for the image ###################################

$nomefile="img".time().rand(1,100);
imagepng( $img,"$direct/".$nomefile.".png" );
imagedestroy( $img );

$rando=rand(1,3);

switch ($rando) {
       case 1:
           $nomefile="<p align=\"center\" ><img border=\"0\" src=\"$direct/"."$nomefile."."png\" ></p>";
           break;
       case 2:
           $nomefile="<p align=\"right\"><img border=\"0\" src=\"$direct/"."$nomefile."."png\" ></p>";
           break;
       case 3:
           $nomefile="<p align=\"left\" ><img border=\"0\" src=\"$direct/"."$nomefile."."png\" ></p>";
           break;
   }

################################################################################################

$file = fopen("$nomepag","r");

$muro = fread($file, filesize("$nomepag"));

fclose($file);

$contenuto="\r<tr>\r";

$contenuto=$contenuto."<td>".$nomefile."</td>\r";

$contenuto=$contenuto."</tr>\r <!-- replace me -->";

$contenuto = ereg_replace("<!-- replace me -->",$contenuto,$muro);

########################################## Writes the File #####################################
$file = fopen("$nomepag","w+");
fputs($file,$contenuto);
fclose($file);

#####################################Finally Display the page! ###################################

include("$nomepag");
?> 

