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

if(!isset($start)){
	$start=0;
}

if(!isset($many)){
	$many=10;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<link rel = "stylesheet" type = "text/css" href = "style.css" />
<script language="javascript">
function openwindow(link,h,w)
{
	toploc = screen.height/2 - h/2;
	leftloc = screen.width/2 - w/2; 
	window.open(link,"popwindow1","width=" + w + ",height=" + h + ",top=" + toploc + ",left=" + leftloc + ",scrollbars=yes,location=no,resizable=yes");
}
</script>
<title></title>
</head>
<?=$adm_body?><?

if(isset($delete)){

	while($ID){

		$delete = sql_query("
			delete from
				$tb_links
			where
				ID='$ID'
		");

		echo "Site ID " . $ID . " has been deleted.<br>\n";
	}
} else {

?><form method="post" action="linkcheck_main.php?<?=session_name()?>=<?=session_id()?>">
<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<tr>
	<td class="theader" width="1%">Delete</td>
	<td class="theader" width="1%">Edit</td>
	<td class="theader" width="98%">Site</td>
</tr><?

$query = sql_query("
	select
		*
	from
		$tb_links
	order by
		ID
	limit
		$start, $many
");

$count = sql_num_rows($query);

while($rows = sql_fetch_array($query)){

	if(substr($rows[SiteURL], 0, 6) != "ftp://"){

		if(!$open = @fopen($rows[SiteURL], "r")){
			$bad_link = 1;
		}
	}

	echo "<tr><td align=\"right\"><input class=\"small\" type=\"checkbox\" name=\"ID[]\"";
	
	if(isset($bad_link)){
		echo " checked";
	}

	unset($bad_link);
	
	echo "></td><td><a ";
	echo "href=\"javascript:openwindow('edit_site.php?" . session_name() . "=";
	echo session_id() . "&amp;ID=" . $rows[ID];
	echo "&amp;p=1',420,520);\">Edit</a></td><td class=\"text\">";
	echo "<a href=\"" . $rows[SiteURL];
	echo "\" target=\"_blank\">";
	echo stripslashes($rows[SiteName]) . "</a> - " . $rows[SiteURL];
	echo $error_message . "</td></tr>";
}

?><tr><td colspan="3"><input class="button" type="submit" name="delete" value =" Delete Sites "></td></tr>
</table></form><?
}
?>
</body>
</html>
