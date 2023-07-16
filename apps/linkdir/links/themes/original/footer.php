<?
// *******************************************************************
//  themes/original/footer.php
// *******************************************************************

$html = $table4 . "\t\t<tr>\r\n\t\t\t<td width=\"100%\" ";
$html .= "align=\"center\" class=\"footerText\">";

$sql = sql_query("
	select
		ID
	from
		$tb_categories
");

$html .= " Total Categories: " . (sql_num_rows($sql)+0);

$sql = sql_query("
	select
		ID
	from
		$tb_links
");

$html .= "&nbsp;&nbsp;Total Links: " . (sql_num_rows($sql)+0);

$sql = sql_query("
	select
		ID
	from
		$tb_terms
");

$html .= "&nbsp;&nbsp;Searches Performed: " . (sql_num_rows($sql)+0);
	
$sql = sql_query("
	select
		sum(HitsIn) as hits_in
	from
		$tb_links
");

$rows = sql_fetch_array($sql);

$html .= "&nbsp;&nbsp;Hits In: " . ($rows["hits_in"]+0);

$sql = sql_query("
	select
		sum(HitsOut) as hits_out
	from
		$tb_links
");

$rows = sql_fetch_array($sql);

$html .= "&nbsp;&nbsp;Hits Out: " . ($rows["hits_out"]+0);

$sql = sql_query("
	select
		count(*) as count
	from
		$tb_sessions
	where
		expire > UNIX_TIMESTAMP() - 300
");

$rows = sql_fetch_array($sql);

$html .= "&nbsp;&nbsp;Visitors Online: " . ($rows["count"]+0);

$html .= "</td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t<td class=\"footerText\" align=\"center\">";

if($SERVER_NAME != "newphplinks.com" && $SERVER_NAME != "www.newphplinks.com"){
	$html .= "<a class=\"footerLink\" href=\"index.php?" . session_name() . "=";
	$html .= session_id() . "\">" . $gl["SiteTitle"] . "</a>&nbsp;";
}

$html .= "<!-- Removing this code will cause you to lose the rights to this license! -->";
$html .= "Powered By <a class=\"footerLink\" ";
$html .= "href=\"http://www.newphplinks.com\">phpLinks</a>";
$html .= "<!-- Removing this code will cause you to lose the rights to this license! -->";
$html .= "</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\r\n\t\t";

echo footertable("100%","center",$html);
unset($html);

$html = "\r\n<p align=\"center\"><a href=\"http://www.newphplinks.com\" ";
$html .= "target=\"_top\"><img src=\"images/powered.gif\" border=\"0\" ";
$html .= "alt=\"Powered By phpLinks\" title=\"Powered By phpLinks\" ";
$html .= "hspace=\"5\" /></a><a href=\"http://php.net/\" target=\"_blank\"><img	";
$html .= "src=\"images/php.gif\" alt=\"PHP.net\" height=\"31\" width=\"88\" ";
$html .= "hspace=\"5\" border=\"0\" /></a><a href=\"http://mysql.com/\" ";
$html .= "target=\"_blank\"><img src=\"images/mysql.gif\"	width=\"88\" ";
$html .= "height=\"31\" border=\"0\" alt=\"MySQL.com\" hspace=\"5\" ";
$html .= "/></a><a href=\"http://validator.w3.org/check/referer\" ";
$html .= "target=\"_blank\"><img src=\"http://www.w3.org/Icons/valid-xhtml10\" ";
$html .= "alt=\"Valid XHTML 1.0!\" title=\"Valid XHTML 1.0!\" height=\"31\" ";
$html .= "width=\"88\" hspace=\"5\" border=\"0\" /></a><a ";
$html .= "href=\"http://jigsaw.w3.org/css-validator/check/referer\" target=\"_blank\"><img ";
$html .= "src=\"http://jigsaw.w3.org/css-validator/images/vcss\" ";
$html .= "alt=\"Valid CSS!\" title=\"Valid CSS!\" hspace=\"5\" border=\"0\" ";
$html .= "/></a></p>";

echo $html;

?>
