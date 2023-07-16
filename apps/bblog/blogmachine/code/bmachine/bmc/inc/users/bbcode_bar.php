<?php

/*
  ===========================

  boastMachine v3.0 Platinum
  Released : Sunday, October 17th 2004 ( 10/17/2004 )
  http://boastology.com

  Developed by Kailash Nadh
  Email   : kailash@bnsoft.net
  Website : www.kailashnadh.name
			www.bnsoft.net

  boastMachine is a free software and is licensed under GPL (General public license)

  ===========================
*/

/****

To define custom bbCode:
use the format

$bb_code[]="TYPE,NAME,SIGN/IMAGE_URL,TAG1,TAG2,ACCESS_KEY";

TYPE - Button or Image
	   0 - button , 1 - image

NAME - Name of the tag

SIGN/IMAGE_URL - The value to be shown if button
						 or
			   - URL to the image, if type = image

TAG1 - The opening bbCode tag

TAG2 - The closing bbCode tag

ACCESS_KEY - A one letter key which enables to click the button
			 using ALT+key
			 Eg: For Bold tag, use B

****/

$bb_code=null; $bb_code=array();

$bb_code[]="0,Bold,B,[B],[/B],B";
$bb_code[]="0,Italics,I,[I],[/I],I";
$bb_code[]="0,Underline,U,[U],[/U],U";
$bb_code[]="0,StrikeThrough,S,[S],[/S],S";
$bb_code[]="0,Image,IMG,[IMG],[/IMG],G";
$bb_code[]="0,Hyperlink,Url,[URL],[/URL],H";
$bb_code[]="0,Color,Clr,[color=red],[/color],C";
$bb_code[]="0,Size,Aa,[size=10],[/size],Z";
$bb_code[]="0,Font,Abc,[font=Arial],[/font],F";
$bb_code[]="0,Code,Code,[code],[/code],O";
$bb_code[]="0,Quote,Q,[quote],[/quote],Q";


// GENERATE THE BB CODES

	for($n=0;$n<=count($bb_code)-1;$n++) {
	list($typ,$name,$sign,$c1,$c2,$key)=explode(",",$bb_code[$n]);

		// Print the image
		if($typ=="1") {
			print "<a style='cursor:hand' accesskey='$key' onClick=bbcode(this,'$c1','$c2',$form_name)><img name='".rand(1,5000)."'src='$sign' title='$name' /></a>&nbsp;\n";
		}
		// Print the button
		else {
			print "<input accesskey=\"$key\" name=\"".rand(1,5000)."\" type=\"button\" onClick=\"javascript:bbcode(this,'$c1','$c2',$form_name);\" value=\"$sign\" title=\"$name (Access Key : $key)\" />&nbsp;\n";
		}

	}
?>