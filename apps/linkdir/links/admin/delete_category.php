<?
// *******************************************************************
//  admin/delete_category.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");
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
</head><?
	echo "<META NAME=\"REFRESH\" HTTP-EQUIV=\"REFRESH\" ";
	echo "content=\"2; URL=categories_main.php?" . session_name() . "=";
	echo session_id() . "&amp;RPID=" . $RPID . "\">";
?>
<?=$adm_body?>
<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<tr>
	<td align="center" class="theader"><?
	
		if(isset($ID)){
			
			$get_cat = sql_query("
				select
					*
				from
					$tb_categories
				where
					ID='$ID'
			");

			$get_row = sql_fetch_array($get_cat);
			
			$check_for_child = sql_query("
				select
					*
				from
					$tb_categories
				where
					PID='$get_row[ID]'
			");

			$count_parent_row = sql_num_rows($check_for_child);

			if($count_parent_row > 0){
				
				echo "<br />Cannot delete " . $get_row[Category];
				echo ", you must<br>delete it's subcategories first.<br /><br />";
				echo "<a href=\"categories.php?" . session_name() . "=";
				echo session_id() . "&amp;RPID=" . $RPID;
				echo "\">Click here to continue</a><br /><br />";
			} else {

				if(
					$delete = sql_query("
						delete from
							$tb_categories
						where
							ID='$ID'
					")
				){
					echo "<br />Category " . $get_row[Category];
					echo " has been deleted.<br /><br />";
					echo "<a href=\"categories_main.php?" . session_name() . "=";
					echo session_id() . "&amp;RPID=" . $RPID;
					echo "\">Click here to continue</a><br /><br />";
				} else {
					echo "<br />Could not delete " . $get_row[Category];
					echo ",<br />it doesn't exist.<br><br>";
					echo "<a href=\"categories.php?" . session_name() . "=";
					echo session_id() . "&amp;RPID=" . $RPID;
					echo "\">Click here to continue</a><br />";
				}
			}
		}
		?></td>
	</tr>
	</table>
</body>
</html>
