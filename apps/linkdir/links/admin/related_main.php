<?
// *******************************************************************
//  admin/related_main.php
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
<?

if(isset($delete)){

	$delete = sql_query("
		delete from
			$tb_related
		where
			id='$id'
	");
}

if(isset($add)){

	$insert = sql_query("
		insert into $tb_related (
			id,
			cat_id,
			rel_id
		) values (
			'',
			'$cat_id',
			'$rel_id'
		)
	");
}

if(isset($update)){

	$update = sql_query("
		update
			$tb_related
		set
			rel_id = '$rel_id'
		where
			id = '$id'
	");
}

?>
<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<?

if(isset($list)){
	echo "<input type=\"hidden\" name=\"list\" value=\"1\">";
}

echo "<tr><td colspan=\"4\" class=\"theader\">Edit Related Categories";
if(isset($update)){echo " - Update Complete";}
if(isset($add)){echo " - Addition Complete";}
if(isset($delete)){echo " - Deletion Complete";}
echo "</td></tr>";

$category_name = sql_query("
	select
		*
	from
		$tb_categories
	where
		ID = '$Category'
");

$name = sql_fetch_array($category_name);

echo "<tr><td align=\"right\" class=\"text\">Category: </td><td colspan=\"3\" class=\"text\">";

unset($gcid);

if(isset($name["ID"])){
	$gcid = $name["ID"];
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
		
		echo ">> ".ereg_replace("_"," ",($cat_array[$depth]));
		
		if($gcid > 0){
			echo "&nbsp;&nbsp;";
		}
	}
}

echo "&nbsp;</td></tr>";

$related = sql_query("
	select
		*
	from
		$tb_related
	where
		cat_id = '$Category'
");

while($related_array = sql_fetch_array($related)){
	
	echo "<tr><td align=\"right\" class=\"text\">Related: </td><form ";
	echo "method=\"post\" action=\"related_main.php?" . session_name();
	echo "=" . session_id() . "&amp;id=" . $related_array["id"];
	echo "&amp;Category=" . $Category . "\"><td><select class=\"small\" ";
	echo "name=\"rel_id\"><option value=\"0\">None</option>";
	drop_related_cats($related_array["rel_id"], 0, "", $cats);
	echo $cats;
	unset($cats);
	echo "</select></td><td><input class=\"button\" type=\"submit\" ";
	echo "name=\"update\" value=\"Update\" /></td>";
	if(isset($fm)){echo "<input type=\"hidden\" name=\"fm\" value=\"1\">";}
	if(isset($list)){echo "<input type=\"hidden\" name=\"list\" value=\"1\">";}
	echo "</form><form ";
	echo "method=\"post\" action=\"related_main.php?" . session_name();
	echo "=" . session_id() . "&amp;id=" . $related_array["id"];
	echo "&amp;Category=" . $Category . "\"><td><input class=\"button\"";
	echo "type=\"submit\" name=\"delete\" value=\"Delete\" /></td>";
	if(isset($fm)){echo "<input type=\"hidden\" name=\"fm\" value=\"1\">";}
	if(isset($list)){echo "<input type=\"hidden\" name=\"list\" value=\"1\">";}
	echo "</form></tr>";
}

echo "</table><br /><table cellspacing=\"0\" cellpadding=\"5\" border=\"1\" ";
echo "align=\"center\" width=\"100%\">";
echo "<tr><td class=\"theader\" colspan=\"2\">Add New Relationship</td></tr>";
echo "<tr><form method=\"post\" action=\"related_main.php?" . session_name();
echo "=" . session_id() . "&amp;cat_id=" . $Category . "&amp;Category=";
echo $Category . "\"><td width=\"50%\" align=\"right\" class=\"text\">Related: ";
echo "</td><td width=\"50%\"><select class=\"small\" name=\"rel_id\">";
echo "<option value=\"0\">Please Select</option>";
drop_related_cats(0, 0, "", $cats);
echo $cats;
unset($cats);
echo "</select></td></tr><tr><td colspan=\"2\" align=\"center\"><input ";
echo "class=\"button\" type=\"submit\" name=\"add\" value=\" Add New ";
echo "Relationship -> \"></td>";
if(isset($fm)){echo "<input type=\"hidden\" name=\"fm\" value=\"1\">";}
if(isset($list)){echo "<input type=\"hidden\" name=\"list\" value=\"1\">";}
echo "</form></tr>";

if((isset($update) || isset($add) || isset($delete)) && isset($fm)){
	?><tr>
		<td colspan="2" align="center"><a href="categories_main.php?<?=session_name()?>=<?=session_id()?>">Return to Categories</a></td>
	</tr><?
}

if((isset($update) || isset($add) || isset($delete)) && isset($list)){
	?><tr>
		<td colspan="2" align="center"><a href="unrelated.php?<?=session_name()?>=<?=session_id()?>">Return to Unrelated List</a></td>
	</tr><?
}

?></table></body>
</html>
