<?
// *******************************************************************
//  admin/menu.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");
include("../include/common.php");

$language = $gl["Language"];

include("../include/lang/$language.php");

include("../include/session.php");
// // tcm remove php warning
// session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<title></title>
<base target="main" />
<link rel = "stylesheet" type = "text/css" href = "style.css" />
</head>
<?=$menu_body?>
<br />
<table border="0" cellpadding="0" cellspacing="0" align="right">
<tr>
	<td align="right" nowrap="nowrap" class="text">
	<span class="title"><?=$menu_1?></span>
	<br />
	<a href="main.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_2?></a>
	<br />
	<a href="../index.php?<?=session_name()?>=<?=session_id()?>" target="_blank"><?=$menu_3?></a>
	<br />
	<br />
	<span class="title"><?=$menu_4?></span>
	<br />
	<a href="configuration.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_5?></a>
	<br />
	<a href="specs.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_6?></a>
	<br />
	<a href="categories.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_7?></a>
	<br />
	<a href="related.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_8?></a>
	<br />
	<a href="sites.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_9?></a>
	<br />
	<a href="add_site.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_10?></a>
	<br />
	<a href="linkcheck.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_11?></a>
	<br />
	<a href="reviews.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_12?></a>
	<br />
	<a href="reset.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_13?></a>
	<br />
	<br />
	<span class="title"><?=$menu_14?></span>
	<br />
	<a href="setup.php?<?=session_name()?>=<?=session_id()?>"><?=$menu_15?></a>
	<br />
	<br />
	<span class="title"><?=$menu_16?></span>
	<br />
	<a href="http://sourceforge.net/projects/phplinks/"><?=$menu_18?></a>
	<br />
	<a href="http://sourceforge.net/projects/phplinks/"><?=$menu_28?></a>
	<br />
	<a href="http://sourceforge.net/projects/phplinks/"><?=$menu_27?></a>
	<br />
	<a href="http://sourceforge.net/projects/phplinks/" target="_blank"><?=$menu_29?></a>
	<br />
	<a href="http://sourceforge.net/projects/phplinks/" target="_blank"><?=$menu_17?></a>
	<br />
	<br />
	<a href="http://php.net/manual/en/"><?=$menu_19?></a>
	<br />
	<a href="http://mysql.com/doc/home.html"><?=$menu_20?></a>
	<br />
	<a href="http://httpd.apache.org/docs/"><?=$menu_22?></a>
	<br />
	<br />
	<span class="title"><?=$menu_23?></span>
	<br />
	<a href="../license"><?=$menu_24?></a>
	<br />
	<a href="../changelog"><?=$menu_25?></a>
	<br />
	<a href="../readme"><?=$menu_26?></a>
	<br />
	<a href="../copying"><?=$menu_30?></a>
	</td>
</tr>
</table>
</body>
</html>
