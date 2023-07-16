<?
// *******************************************************************
//  include/about.php
// *******************************************************************

$htmlsrc = $table2 . "<tr><td class=\"whatText\"><b>" . $about_1;
$htmlsrc .= $site_title . "</b></td></tr></table>";

echo whattable("100%","center","",$htmlsrc);
unset($htmlsrc);

$htmlsrc = $table2 . "<tr><td class=\"regularText\"><br />";
$htmlsrc .= "<ul><li>" . $about_2 . "<br /><br /><ul><li><a ";
$htmlsrc .= "href=\"http://www.php.net/\" target=\"_blank\">PHP4.x</a>";
$htmlsrc .= $about_3 . "<br /><br /></li><li>" . $about_4 . "<a ";
$htmlsrc .= "href=\"http://httpd.apache.org/\" target=\"_blank\">Apache</a>.";
$htmlsrc .= "<br /><br /></li><li><a href=\"http://www.mysql.com/\" ";
$htmlsrc .= "target=\"_blank\">MySQL 3.22</a> " . $about_5 . "<br /><br />";
$htmlsrc .= "</li></ul></li><li>" . $about_6 . "<br /><br /></li><li>";
$htmlsrc .= $about_7 . "<a class=\"regularText\" ";
$htmlsrc .= "href=\"http://www.newphplinks.com/\" ";
$htmlsrc .= "target=\"_blank\">" . $about_8 . "</a>.<br /><br /></li><li><a ";
$htmlsrc .= "class=\"regularText\" ";
$htmlsrc .= "href=\"http://www.newphplinks.com/\" ";
$htmlsrc .= "target=\"_blank\">";
$htmlsrc .= $about_9 . "</a><br /><br /></li></ul></td></tr></table>";

echo table("100%","center","",$htmlsrc);
unset($htmlsrc);

?>
