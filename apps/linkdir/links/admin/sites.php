<?
// *******************************************************************
//  admin/sites.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");

include("../include/common.php");
$language = $gl["Language"];

include("../include/lang/$language.php");

include("../include/session.php");
// tcm remove php warning
// session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"DTD/xhtml1-frameset.dtd">
<html>
<head>
<title></title>
</head>
<frameset rows="42,*">
<frame name="sites_top" scrolling="no" target="sites_main" src="sites_top.php?<?=session_name()?>=<?=session_id()?>" marginwidth="10" marginheight="10" topmargin="10" leftmargin="10">
<frame name="sites_main" scrolling="auto" src="sites_main.php?<?=session_name()?>=<?=session_id()?>" marginwidth="10" marginheight="10" topmargin="10" leftmargin="10">
</frameset>
</html>