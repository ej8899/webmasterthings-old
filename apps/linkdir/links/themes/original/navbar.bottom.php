<?
// *******************************************************************
//  themes/original/navbar.bottom.php
// *******************************************************************

unset($html);

$html = "\r\n\r\n\t\t<!-- Start Navbar Bottom themes/original/navbar.bottom.php -->";
$html .= $table4 . "\t\t<tr>\r\n\t\t\t<td width=\"100%\" valign=\"middle\" ";
$html .= "class=\"navBot\" align=\"center\">[ <a class=\"NavBotLink\" ";
$html .= "href=\"index.php?" . session_name() . "=" . session_id() . "\">Home</a> | ";
	
if($show == "new"){
	$html .= "<b>What's New</b> | ";
} else {
	$html .= "<a class=\"NavBotLink\" href=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=new\">What's New</a> | ";
}

if($show == "cool"){
	$html .= "<b>What's Cool</b> | ";
} else {
	$html .= "<a class=\"NavBotLink\" href=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=cool\">What's Cool</a> | ";
}

if($show == "pop"){
	$html .= "<b>What's Popular</b> | ";
} else {
	$html .= "<a class=\"NavBotLink\" href=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=pop\">What's Popular</a> | ";
}

if($show == "add"){
	$html .= "<b>Add Site</b> | ";
} else {
	$html .= "<a class=\"NavBotLink\" href=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=add&amp;PID=";
	$html .= $PID . "\">Add Site</a> | ";
}

if($show == "about"){
	$html .= "<b>About</b>";
} else {
	$html .= "<a class=\"NavBotLink\" href=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=about\">About</a>";
}

if($SERVER_NAME == "phplinks.org" || $SERVER_NAME == "dev.phplinks.org"){
	$html .= " | <a class=\"NavBotLink\" target=\"_blank\" ";
	$html .= "href=\"http://phplinks.org/downloads/\">Download</a> | ";
	$html .= "<a class=\"NavBotLink\" target=\"_blank\" ";
	$html .= "href=\"http://phplinks.org/downloads/themes/\">Themes</a> | ";
	$html .= "<a class=\"NavBotLink\" target=\"_blank\" ";
	$html .= "href=\"http://phplinks.org/downloads/language/\">Language Files</a> | "; 
	$html .= "<a class=\"NavBotLink\" target=\"_blank\" ";
	$html .= "href=\"http://board.phplinks.org/\">Discussion</a>";
}

$html .= " ]</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t";
$html .= "<!-- End Navbar Bottom -->\r\n\r\n";

echo navtablebottom("100%","center",$html);
unset($html);
?>
