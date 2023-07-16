<?
// *******************************************************************
//  themes/original/navbar.top.php
// *******************************************************************

$html = "\r\n<!-- Start Top NavBar Table themes/original/navbar.top.php -->";
$html .= "\r\n<table cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" ";
$html .= "border=\"0\">\r\n<tr>\r\n\t<td nowrap=\"nowrap\">\r\n\t<table ";
$html .= "class=\"homebalkback\" cellspacing=\"1\" cellpadding=\"0\" ";
$html .= "width=\"100%\" border=\"0\">\r\n\t<tr>\r\n\t\t<td nowrap=\"nowrap\" ";
$html .= "width=\"16%\" class=\"navbaroff\" align=\"center\"><a class=\"ttd\" ";
$html .= "target=\"_top\" href=\"index.php?" . session_name() . "=";
$html .= session_id() . "\">Browse</a></td>";

if($show=="new"){
	
	$html .= "\r\n\t\t<td width=\"16%\" class=\"navbaron\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\">What's New</td>";
} else {
	
	$html .= "\r\n\t\t<td width=\"16%\" class=\"navbaroff\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\"><a target=\"_top\" class=\"ttd\" ";
	$html .= "href=\"index.php?" . session_name() . "=" . session_id();
	$html .= "&amp;show=new\">What's New</a></td>";
}
		
if($show=="cool"){
	
	$html .= "\r\n\t\t<td width=\"17%\" class=\"navbaron\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\">What's Cool</td>";
} else {
	
	$html .= "\r\n\t\t<td width=\"17%\" class=\"navbaroff\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\"><a target=\"_top\" class=\"ttd\" ";
	$html .= "href=\"index.php?" . session_name() . "=" . session_id();
	$html .= "&amp;show=cool\">What's Cool</a></td>";
}

if($show=="pop"){
	
	$html .= "\r\n\t\t<td width=\"17%\" class=\"navbaron\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\">What's Popular</td>";
} else {
	
	$html .= "\r\n\t\t<td width=\"17%\" class=\"navbaroff\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\"><a target=\"_top\" class=\"ttd\" ";
	$html .= "href=\"index.php?" . session_name() . "=" . session_id();
	$html .= "&amp;show=pop\">What's Popular</a></td>";
}

if($show=="add"){
	
	$html .= "\r\n\t\t<td width=\"16%\" class=\"navbaron\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\">Add A Site</td>";
} else {
	
	$html .= "\r\n\t\t<td width=\"16%\" class=\"navbaroff\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\"><a target=\"_top\" class=\"ttd\" ";
	$html .= "href=\"index.php?" . session_name() . "=" . session_id();
	$html .= "&amp;show=add&amp;PID=" . $PID . "\" ";
	$html .= "target=\"_top\">Add A Site</a></td>";
}

if($show=="about"){
	
	$html .= "\r\n\t\t<td width=\"16%\" class=\"navbaron\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\">About</td>";
} else {
	
	$html .= "\r\n\t\t<td width=\"16%\" class=\"navbaroff\" ";
	$html .= "align=\"center\" nowrap=\"nowrap\"><a target=\"_top\" class=\"ttd\" ";
	$html .= "href=\"index.php?" . session_name() . "=" . session_id();
	$html .= "&amp;show=about\">About</a></td>";
}

$html .= "\r\n\t</tr>\r\n\t</table>\r\n\t</td>\r\n</tr>\r\n</table>";
$html .= "\r\n<!-- Stop Top NavBar Table -->\r\n";

echo $html;
unset($html);

?>
