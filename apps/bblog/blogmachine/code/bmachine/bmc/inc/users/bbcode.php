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

// BB CODE PARSER FOR boastMachine


function BBCode($text=null) {
	if(!trim($text)) { return; }

	// Set up the parameters for a URL search string
	$URLSearchString = "\r\n a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
	// Set up the parameters for a MAIL search string
	$MAILSearchString = $URLSearchString . " a-zA-Z0-9\.@";

	// Perform URL Search
	$text = preg_replace("/\[url\]([$URLSearchString]*)\[\/url\]/is", '<a href="$1">$1</a>', $text);
	$text = preg_replace("(\[url\=([$URLSearchString]*)\](.+?)\[/url\])is", '<a href="$1" title="$1">$2</a>', $text);

	$text = preg_replace("/\[a\]([$URLSearchString]*)\[\/a\]/is", '<a href="$1" title="$1">$1</a>', $text);
	$text = preg_replace("(\[a\=([$URLSearchString]*)\](.+?)\[/a\])is", '<a href="$1" title="$1">$2</a>', $text);

	// Perform MAIL Search
	$text = preg_replace("(\[mail\]([$MAILSearchString]*)\[/mail\])is", '<a href="mailto:$1">$1</a>', $text);
	$text = preg_replace("/\[mail\=([$MAILSearchString]*)\](.+?)\[\/mail\]/is", '<a href="mailto:$1">$2</a>', $text);


	$text = preg_replace("/\[b\](.+?)\[\/b\]/is", '<strong>$1</strong>', $text);


	// Check for Italics $text
	$text = str_replace("[i]","<span style=\"font-style: italic;\">",$text);
	$text = str_replace("[I]","<span style=\"font-style: italic;\">",$text);
	$text = str_replace("[/i]","</span>",$text);
	$text = str_replace("[/I]","</span>",$text);

	// Check for Underline $text
	$text = str_replace("[u]","<span style=\"text-decoration: underline;\">",$text);
	$text = str_replace("[U]","<span style=\"text-decoration: underline;\">",$text);
	$text = str_replace("[/u]","</span>",$text);
	$text = str_replace("[/U]","</span>",$text);

	// Check for strike-through $text
	$text = str_replace("[s]","<span style=\"text-decoration: line-through;\">",$text);
	$text = str_replace("[S]","<span style=\"text-decoration: line-through;\">",$text);
	$text = str_replace("[/s]","</span>",$text);
	$text = str_replace("[/S]","</span>",$text);

	// Check for colored $text
	$text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<span style=\"color: $1\">$2</span>",$text);

	// Check for sized $text
	$text = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is","<span style=\"font-size: $1px;\">$2</span>",$text);

	// Check for font change $text
	$text = preg_replace("(\[font=(.+?)\](.+?)\[\/font\])is","<span style=\"font-family: $1\">$2</span>",$text);

	// Check for [code] $text
	$text = preg_replace("/\[code\](.+?)\[\/code\]/is","<div style=\"width: 60%; background-color: #f6f6f6; font-family: Courier, Verdana; font-ize: 9px; color: #264779; padding: 10px; border-width:1px; border-color:#D5D5D5; border-style:solid;\"><strong>CODE:</strong><br />$1</div>", $text);

	// Declare the format for [quote] layout
	$text = preg_replace("/\[quote\](.+?)\[\/quote\]/is","<div style=\"width: 60%; background-color: #f6f6f6; font-family: Verdana; font-ize: 9px; color: #CC0000; padding: 10px; border-width:1px; border-color:#D5D5D5; border-style:solid;\"><strong>QUOTE:</strong><br />$1</div>", $text);

	// Images
	// [img]pathtoimage[/img]
	$text = preg_replace("/\[img\](.+?)\[\/img\]/is", '<img src="$1" alt="Image" />', $text);

	// [img=width * height]image source[/img]
	// eg: [img=420*60]http://ite.com/a.gif[/img]

	$text = preg_replace("/\[img\=([0-9]*)\*([0-9]*)\](.+?)\[\/img\]/is", '<img src="$3" height="$2" width="$1" alt="Image" />', $text);

	return $text;

	}
?>