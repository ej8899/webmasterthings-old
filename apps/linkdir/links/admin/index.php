<?
// *******************************************************************
//  admin/index.php
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"DTD/xhtml1-frameset.dtd">

<html>
	<head>
		<title>NewPHPLinks Admin</title>
	</head>
	<frameset cols="160,*">
		<frame name="menu" src="menu.php?<?=session_name()?>=<?=session_id()?>" scrolling="auto" marginwidth="10" marginheight="10" topmargin="10" leftmargin="10" />
		<frame name="main" src="main.php?<?=session_name()?>=<?=session_id()?>" scrolling="auto" marginwidth="10" marginheight="10" topmargin="10" leftmargin="10" />
	</frameset>
</html>
