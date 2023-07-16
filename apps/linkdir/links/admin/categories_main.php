<?
// *******************************************************************
//  admin/categories.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");

include("../include/common.php");
$language = $gl["Language"];

include("../include/lang/$language.php");

include("../include/session.php");
// tcm remove php warning
// session_start();

if(isset($RPID)){$PID = $RPID;}

if(!isset($PID)){$PID = 0;}

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
<tr>
	<td colspan="10">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="50%" class="text"><?
		
		$html = "&nbsp;<a href=\"categories_main.php?" . session_name() . "=";
		$html .= session_id() . "&amp;PID=0" . "\">Top</a> ";
		
		unset($gcid);

		if(isset($PID)){
			$gcid = $PID;
		}

		while($gcid > 0){
			
			$mlc_query = sql_query("
				select
					*
				from
					$tb_categories
				where
					ID = '$gcid'
			");

			$mlc_array = sql_fetch_array($mlc_query);
			$cat_array[] = $mlc_array[Category];
			$pid_array[] = $mlc_array[ID];
			$gcid = $mlc_array[PID];
		}

		$count = sizeof($pid_array);

		for($depth=$count;$depth>=0;$depth--){	
			
			if($pid_array[$depth]){
				
				if($PID == $pid_array[$depth]){

					$html .= ">> ";
					$html .= ereg_replace("_"," ",($cat_array[$depth]));
					$html .= "&nbsp;&nbsp;";
				} else {
					
					$html .= ">> <a href=\"categories_main.php?" . session_name() . "=" . session_id() . "&amp;PID=";
					$html .= $pid_array[$depth] . "\">";
					$html .= ereg_replace("_"," ",($cat_array[$depth]));
					$html .= "</a>&nbsp;&nbsp;";
				}
			}
		}
		
		echo $html;
		unset($html);

	?></td>
	<td width="50%" align="right" nowrap="nowrap" class="text">[ <a href="insert_category.php?<?=session_name()?>=<?=session_id()?>">Insert Top Level Categories</a> ] <?
		if(isset($PID) && $PID != 0){
			?>[ <a href="insert_category.php?<?=session_name()?>=<?=session_id()?>&amp;PID=<?=$PID?>">Insert Children Categories</a> ] <?
			}
		?></td>
	</tr>
	</table>
	</td>
	</tr>
	<tr bgcolor="#dddddd">
		<td align="center" class="theader">Categories</td>
		<td align="center" width="1%" nowrap="nowrap" class="text">Allow<br />Sites</td>
		<td align="center" width="1%" nowrap="nowrap" class="text">Show<br />Count</td>
		<td align="center" width="1%" nowrap="nowrap" class="text"># of<br />Sites</td>
		<td align="center" width="1%" nowrap="nowrap" class="text">Child<br />Type</td>
		<td align="center" width="1%" nowrap="nowrap" class="text">Child<br />Count</td>
		<td align="center" width="1%" nowrap="nowrap" class="text">Edit<br />Cats</td>
		<td align="center" width="1%" nowrap="nowrap" class="text">Related<br />Cats</td>
		<td align="center" width="1%" nowrap="nowrap" class="text">Insert<br />Child</td>
		<td align="center" width="1%" nowrap="nowrap" class="text">Delete<br />Cats</td>
	</tr><?

	$pixel = "<img src=\"images/pixel.gif\" valign=\"middle\" width=\"1\" ";
	$pixel .= "height=\"1\" alt=\"\" hspace=\"15\" />";

	$get_cats = sql_query("
		select
			*
		from
			$tb_categories
		where
			PID='$PID'
		order by
			Category asc
	");

	while($get_rows = sql_fetch_array($get_cats)){

		$cc++;
		$cell_color = "#eeeeee";
		$cc % 2  ? 0 : $cell_color = "#dddddd";

		echo "<tr bgcolor=\"" . $cell_color . "\">";

		$count_sites = sql_query("
			select
				count(*) as count
			from
				$tb_links
			where
				Category='$get_rows[ID]'
		");

		$count_array = sql_fetch_array($count_sites);

		echo "<td align=\"left\" valign=\"middle\"><a ";
		echo "href=\"categories_main.php?" . session_name() . "=";
		echo session_id() . "&amp;PID=" . $get_rows["ID"] . "\">";
		echo eregi_replace("_"," ",$get_rows["Category"]) . "</a></td>";
		echo "<td align=\"center\"><span class=\"transtext\">" . $get_rows["AllowSites"] . "</span></td>";
		echo "<td align=\"center\"><span class=\"transtext\">" . $get_rows["ShowSiteCount"] . "</span></td>";
		echo "<td align=\"center\"><span class=\"transtext\">" . $count_array["count"] . "</span></td>";
		echo "<td align=\"center\"><span class=\"transtext\">" . $get_rows["Children"] . "</span></td>";
		echo "<td align=\"center\"><span class=\"transtext\">" . $get_rows["TopChildren"] . "</span></td>";
		echo "<td align=\"center\"><a href=\"edit_category.php?";
		echo session_name() . "=" . session_id() . "&amp;ID=";
		echo $get_rows["ID"] . "\">Edit</a></td>";
		echo "<td align=\"center\"><a href=\"related_main.php?";
		echo session_name() . "=" . session_id() . "&amp;Category=";
		echo $get_rows["ID"] . "&fm=1\">Related</a></td>";
		echo "<td align=\"center\"><a href=\"insert_category.php?";
		echo session_name() . "=" . session_id() . "&amp;PID=";
		echo $get_rows["ID"] . "\">Insert</a></td>";
		echo "<td align=\"center\"><a href=\"delete_category.php?";
		echo session_name() . "=" . session_id() . "&amp;ID=";
		echo $get_rows["ID"] . "\">Delete</a></td></tr>";
		
		$get_sub_cats = sql_query("
			select
				*
			from
				$tb_categories
			where
				PID='$get_rows[ID]'
			order by
				Category asc
		");

		while($get_sub_rows = sql_fetch_array($get_sub_cats)){

			$cc++;
			$cell_color = "#eeeeee";
			$cc % 2  ? 0 : $cell_color = "#dddddd";

			echo "<tr bgcolor=\"" . $cell_color . "\"><td align=\"left\">";

			for($i=0;$i<1;$i++){
				echo $pixel;
			}

			$count_sites = sql_query("
				select
					count(*) as count
				from
					$tb_links
				where
					Category='$get_sub_rows[ID]'
			");

			$count_array = sql_fetch_array($count_sites);

			echo "<a href=\"categories_main.php?" . session_name() . "=";
			echo session_id() . "&amp;PID=" . $get_sub_rows["ID"] . "\">";
			echo eregi_replace("_"," ",$get_sub_rows["Category"]) . "</a></td>";
			echo "<td align=\"center\"><span class=\"transtext\">" . $get_sub_rows["AllowSites"] . "</span></td>";
			echo "<td align=\"center\"><span class=\"transtext\">" . $get_sub_rows["ShowSiteCount"] . "</span></td>";
			echo "<td align=\"center\"><span class=\"transtext\">" . $count_array["count"] . "</span></td>";
			echo "<td align=\"center\"><span class=\"transtext\">" . $get_sub_rows["Children"] . "</span></td>";
			echo "<td align=\"center\"><span class=\"transtext\">" . $get_sub_rows["TopChildren"] . "</span></td>";
			echo "<td align=\"center\"><a href=\"edit_category.php?";
			echo session_name() . "=" . session_id() . "&amp;ID=";
			echo $get_sub_rows["ID"] . "\">Edit</a></td>";
			echo "<td align=\"center\"><a href=\"related_main.php?";
			echo session_name() . "=" . session_id() . "&amp;Category=";
			echo $get_sub_rows["ID"] . "&fm=1\">Related</a></td>";
			echo "<td align=\"center\"><a href=\"insert_category.php?";
			echo session_name() . "=" . session_id() . "&amp;PID=";
			echo $get_sub_rows["ID"] . "\">Insert</a></td>";
			echo "<td align=\"center\"><a href=\"delete_category.php?";
			echo session_name() . "=" . session_id() . "&amp;ID=";
			echo $get_sub_rows["ID"] . "\">Delete</a></td></tr>";
			
			$get_sub2_cats = sql_query("
				select
					*
				from
					$tb_categories
				where
					PID='$get_sub_rows[ID]'
				order by
					Category asc
			");

			while($get_sub2_rows = sql_fetch_array($get_sub2_cats)){

				$cc++;
				$cell_color = "#eeeeee";
				$cc % 2  ? 0 : $cell_color = "#dddddd";

				echo "<tr bgcolor=\"" . $cell_color . "\"><td align=\"left\">";

				for($i=0;$i<2;$i++){
					echo $pixel;
				}

				$count_sites = sql_query("
					select
						count(*) as count
					from
						$tb_links
					where
						Category='$get_sub2_rows[ID]'
				");

				$count_array = sql_fetch_array($count_sites);

				echo "<a href=\"categories_main.php?" . session_name() . "=";
				echo session_id() . "&amp;PID=" . $get_sub2_rows["ID"];
				echo "\">" . eregi_replace("_"," ",$get_sub2_rows["Category"]);
				echo "</a></td><td align=\"center\"><span class=\"transtext\">";
				echo $get_sub2_rows["AllowSites"] . "</span></td>";
				echo "<td align=\"center\"><span class=\"transtext\">" . $get_sub_rows["ShowSiteCount"] . "</span></td>";
				echo "<td align=\"center\"><span class=\"transtext\">" . $count_array["count"] . "</span></td>";
				echo "<td align=\"center\"><span class=\"transtext\">" . $get_sub2_rows["Children"];
				echo "</span></td><td align=\"center\"><span class=\"transtext\">" . $get_sub2_rows["TopChildren"];
				echo "</span></td><td align=\"center\">";
				echo "<a href=\"edit_category.php?" . session_name() . "=";
				echo session_id() . "&amp;ID=" . $get_sub2_rows["ID"];
				echo "\">Edit</a></td><td align=\"center\">";
				echo "<a href=\"related_main.php?" . session_name() . "=";
				echo session_id() . "&amp;Category=";
				echo $get_sub2_rows["ID"] . "&amp;fm=1\">Related</a></td>";
				echo "<td align=\"center\"><a href=\"insert_category.php?";
				echo session_name() . "=" . session_id() . "&amp;PID=";
				echo $get_sub2_rows["ID"] . "\">Insert</a></td>";
				echo "<td align=\"center\"><a href=\"delete_category.php?";
				echo session_name() . "=" . session_id() . "&amp;ID=";
				echo $get_sub2_rows["ID"] . "\">Delete</a></td></tr>";
			}
		}
	}
	?>
	<tr>
		<td colspan="10" align="right" class="text">[ <a href="insert_category.php?<?=session_name()?>=<?=session_id()?>">Insert Top Level Categories</a> ] <?
			if(isset($PID) && $PID != 0){
				?>[ <a href="insert_category.php??<?=session_name()?>=<?=session_id()?>&amp;PID=<?=$PID?>">Insert Children Categories</a> ] <?
			}
		?></td>
	</tr>
</table>
</body>
</html>
