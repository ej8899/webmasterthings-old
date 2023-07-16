<?
// *******************************************************************
//  admin/linkcheck_main.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");

include("../include/common.php");
$language = $gl["Language"];

include("../include/lang/$language.php");

include("../include/session.php");
// tcm remove php warning
// session_start();

if(!isset($x)){	$x=0;}

if(!isset($many)){$many=10;}

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
<tr><form method="post" action="linkcheck_main.php?<?=session_name()?>=<?=session_id()?>" target="linkcheck_main">
	<td class="text">Select Range: <select class="small" name="start" 
	onChange="window.open(this.options[this.selectedIndex].value,'linkcheck_main')">
	<option selected="selected">Link ID Range</option><?
		
		$sql = sql_query("
			select
				ID
			from
				$tb_links
		");

		$count = sql_num_rows($sql);

		while($x<$count){
			
			echo "<option value=\"linkcheck_main.php?" . session_name() . "=";
			echo session_id() . "&amp;start=" . ($x+1);
			echo "&amp;many=" . $many . "\">" . ($x+1) . " - ";
			
			if(($x+$many)>$count){echo $count;} else {echo ($x+$many);}

			echo "</option>\n";
			
			$x=$x+$many;
		}
	?>
	</select></td></form>
	<form method="post" action="linkcheck_top.php?<?=session_name()?>=<?=session_id()?>" target="linkcheck_top">
	<td class="text">&nbsp;&nbsp;&nbsp;&nbsp;Interval: <input class="small" type="text" name="many" value="<?=$many?>" size="4"><input class="button" type="submit" value="Rebuild Range"></td></form>
</tr>
</table>
</body>
</html>
