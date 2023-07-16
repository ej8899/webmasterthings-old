<?
// *******************************************************************
//  include/owner.php
// *******************************************************************

$htmlsrc = $table2 . "<tr><td class=\"whatText\">" . $owner_1;
$htmlsrc .= "</td></tr></table>";

echo whattable("100%","center","",$htmlsrc);
unset($htmlsrc);


if(isset($ID)){

	$htmlsrc = "<br /><form action=\"\">" . $table2 . "<tr><td>" . $table;
	$htmlsrc .= "<tr><td class=\"regularText\">" . $owner_2 . $site_title;
	$htmlsrc .= ":</td></tr><tr><td class=\"regularText\" align=\"center\"><br />";
	$htmlsrc .= "<textarea class=\"textBox\" name=\"name\" rows=\"4\" ";
	$htmlsrc .= "cols=\"45\" readonly=\"readonly\">&lt;a href=\"" . $base_url;
	$htmlsrc .= "/in.php?ID=" . $ID . "\"&gt;" . $site_title . "&lt;/a&gt;</textarea>";
	$htmlsrc .= "</td></tr><tr><td class=\"regularText\"><br />" . $owner_3;
	$htmlsrc .= "</td></tr><tr><td class=\"regularText\" align=\"center\"><br />";
	$htmlsrc .= "<textarea class=\"textBox\" name=\"name\" rows=\"4\" ";
	$htmlsrc .= "cols=\"45\" readonly=\"readonly\">&lt;a href=\"" . $base_url;
	$htmlsrc .= "/index.php?show=review_add&amp;SiteID=" . $ID . "\"&gt;";
	$htmlsrc .= $owner_4 . "&lt;/a&gt;</textarea></td></tr><tr><td ";
	$htmlsrc .= "class=\"regularText\" align=\"center\"><a class=\"regularText\" ";
	$htmlsrc .= "href=\"index.php?" . session_name() . "=" . session_id();
	$htmlsrc .= "&amp;show=update&amp;ID=" . $ID . "\"><br />" . $owner_5;
	$htmlsrc .= "</a>.<br /><br /></td></tr></table></td></tr></table></form>";

} else {

	$htmlsrc .= "<form method=\"post\" action=\"index.php?" . session_name();
	$htmlsrc .= "=" . session_id() . "&amp;show=owner\">" . $table2 . "<tr><td ";
	$htmlsrc .= "class=\"regularText\">" . $owner_6 . "<input class=\"textBox\" ";
	$htmlsrc .= "type=\"text\" name=\"ID\" size=\"5\"><input type=\"submit\" ";
	$htmlsrc .= "name=\"submit\" value=\"" . $owner_7 . "\"></td></tr>";
	$htmlsrc .= "</table></form>";
}

echo table("100%","center","",$htmlsrc);
unset($htmlsrc);

?>

