<?
// *******************************************************************
//  admin/sites_top.php
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
<tr><form method="post" action="sites_main.php?<?=session_name()?>=<?=session_id()?>" target="sites_main">
	<td class="text">Select Category: <select class="small" name="Category" onChange="window.open(this.options[this.selectedIndex].value,'sites_main')">
	<option selected="selected">Please Select</option><?
		
		$find_new = sql_query("select * from $tb_temp");
		$count_new = sql_num_rows($find_new);
		
		if($count_new > 0){
			echo "<option value=\"sites_main.php?" . session_name() . "=";
			echo session_id() . "&amp;submit=1&amp;Category=-1\">Sites ";
			echo "that need to be validated</option>";
		}
		
		$find_nulls = sql_query("
			select
				*
			from
				$tb_links
			where
				Category='0'
			or
				Category=''
		");

		$count_nulls = sql_num_rows($find_nulls);
		
		if($count_nulls > 0){
			
			echo "<option value=\"sites_main.php?" . session_name() . "=";
			echo session_id() . "&amp;submit=1&amp;Category=0\">Sites ";
			echo "not in a Category</option>";
		}

		admin_drop_cats(0, "", $cats);
		echo $cats;

	?></select></td></form><form method="post" action="">
<td>&nbsp;<input class="button" type="button" name="reload" onclick="javascript: window.location.reload();" value="Reload" /></td>
</tr>
</form>
</table>
</body>
</html>
