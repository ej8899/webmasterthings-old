<?
// *******************************************************************
//  admin/unrelated.php
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
<?=$adm_body?>
<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<?
	$query = sql_query("
		select
			$tb_categories.ID as cat_id
		from
			$tb_categories
		left join
			$tb_related
		on
			$tb_categories.ID=$tb_related.cat_id
		where
			$tb_related.cat_id is null
		and
			$tb_categories.PID != '0'
		order by
			$tb_categories.ID
	");

	if(sql_num_rows($query)>0){
		
		?><tr><td class="theader">Unrelated Categories</td></tr><?
		
		while($rows = sql_fetch_array($query)){

			echo "<tr><td><a href=\"related_main.php?" . session_name() . "=";
			echo session_id() . "&amp;submit=1&amp;list=1&amp;Category=";
			echo $rows[cat_id] . "\">";
			
			unset($gcid);
			
			if(isset($rows[cat_id])){
				
				$gcid = $rows[cat_id];
			}

			while($gcid > 0){
				
				$mlc_sql = "
					select
						*
					from
						$tb_categories
					where
						ID = '$gcid'
				";

				$mlc_query = sql_query($mlc_sql);
				$mlc_array = sql_fetch_array($mlc_query);
				
				$cat_array[] = $mlc_array["Category"];
				$pid_array[] = $mlc_array["ID"];
				$gcid = $mlc_array["PID"];
			}

			$count = sizeof($pid_array);

			for($depth=$count;$depth>=0;$depth--){	
				
				if($pid_array[$depth]){
					
					echo " >> " . ereg_replace("_"," ",($cat_array[$depth]));
					
					if($gcid > 0){
						
						echo "&nbsp;&nbsp;";
					}
				}
			}

			unset($pid_array);
			unset($cat_array);
			
			echo "</a></td></tr>";
		}
	} else {
		?><tr><td class="theader">No Unrelated Categories found.</td></tr><?
	}
?>
</table>
</body>
</html>
