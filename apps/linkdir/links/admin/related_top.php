<?
// *******************************************************************
//  admin/related_top.php
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<title></title>
<link rel = "stylesheet" type = "text/css" href = "style.css" />
</head>
<?=$top_body?>
<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr><form method="post" action="related_main.php?<?=session_name()?>=<?=session_id()?>" target="related_main" name="form1">
	<td align="center" valign="middle" class="text">Select Category: <select class="small" name="Category" 
	onChange="window.open(this.options[this.selectedIndex].value,'related_main')">
	<option selected="selected">Please Select</option>
	<option value="unrelated.php?<?=session_name()?>=<?=session_id()?>">Unrelated Categories</option><?
	admin_related_cats(0, "", $cats);
	echo $cats;
	?></select></td>
	</form>
	<form method="post" action=""><td align="center" valign="middle">&nbsp;<input class="button" type="button" name="reload" onclick="javascript: window.location.reload();" value="Reload" /></td>
</tr></form>
</table>
</body>
</html>
