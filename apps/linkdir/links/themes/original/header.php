<?
// *******************************************************************
//  themes/original/header.php
// *******************************************************************

$radio_array = array(
	"or"		=>	$common_1,
	"and"		=>	$common_2,
	"phrase"	=>	$common_3
);

$html = "" . $table2 . "\t\t\r\n\t\t<tr><form target=\"_top\" method=\"post\" action=\"index.php?" . session_name() . "=";
$html .= session_id() . "\">\r\n\t\t\t<td ";
$html .= "class=\"title\" nowrap=\"nowrap\" valign=\"bottom\"><a href=\"index.php?";
$html .= session_name() . "=" . session_id() . "\" target=\"_top\"><img src=\"themes/";
$html .= $theme . "/title.gif\" align=\"left\" width=\"200\" height=\"49\" ";
$html .= "border=\"0\" ";
$html .= "alt=\"" . $gl["SiteTitle"] . "\" title=\"" . $gl["SiteTitle"];
$html .= "\" /></a></td>\r\n\t\t\t<td align=\"right\" nowrap=\"nowrap\">&nbsp;";
$html .= "<font class=\"searchText\">Search:</font> <input ";
$html .= "class=\"textBox\" type=\"text\" name=\"term\" value=\"";
$html .= stripslashes($term) . "\" size=\"20\" /><br /><font ";
$html .= "class=\"searchLogic\">&nbsp;";


if(
	(isset($PID) && strlen($PID)>0) ||
	(isset($search_cat) && $search_cat != 0)
){
	$html .= "<img src=\"images/pixel.gif\" width=\"3\" height=\"1\" ";
	$html .= "alt=\"\" /><select name=\"search_cat\" ";
	$html .= "class=\"textBox\"><option value=\"";
			
	if(isset($PID)){
		$html .= $PID;
	} else {
		$html .= $search_cat;
	}
			
	$html .= "\" selected=\"selected\"> -- This Category -- </option><option ";
	$html .= "value=\"0\"> -- All Categories -- </option></select><br />";
}
		
if(!isset($logic)){
	$logic = "or";
}

while(list($key, $value) = each($radio_array)){
			
	$html .= "<input type=\"radio\" name=\"logic\" value=\"" . $key . "\"";
				
	if($logic == $value){
		$html .= " checked=\"checked\"";
	}
	
	$html .= " /> " . $value . "&nbsp;";
}

if(isset($ns)){
	echo "<input type=\"hidden\" name=\"ns\" value=\"1\" />";
}
			
$html .= "</font><input type=\"submit\" value=\"Go!\" align=\"top\" ";
$html .= "alt=\"Search\" title=\"Search\" /></td></form>\r\n\t\t</tr>\r\n\t\t";
$html .= "\r\n\t\t</table>\r\n\t\t\r\n";

echo table("100%", "center", "", $html);

?>
