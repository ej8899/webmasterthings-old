<?
// *******************************************************************
//  admin/edit_site.php
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
if(isset($update) && isset($ID)){

	$result = sql_query("
		update
			$tb_links
		set
			SiteName='$SiteName',
			SiteURL='$SiteURL',
			Description='$Description',
			Category='$Category',
			Country='$Country',
			Email='$Email'
		where
			ID='$ID'
	");

	
}

if(isset($ID)){

	$get_site = sql_query("
		select
			*
		from
			$tb_links
		where
			ID='$ID'
	");

	$rows = sql_fetch_array($get_site);
	
	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr><form method="post" action="edit_site.php?<?=session_name()?>=<?=session_id()?>">
	<input type="hidden" name="ID" value="<?=$ID?>"><?
	
		if($p==1){
			?><input type="hidden" name="p" value="1"><?
		}

		?><td colspan="2" class="theader">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td class="theader">Edit Site<?
					if(isset($update) && isset($ID)){
						?> - Site Has been updated.<?
					} 
					?></td><?
					if($p==1){
						?><td align="right" class="text">[ <a 
		href="<?=$rows[SiteURL]?>" target="_blank">View Site</a> ] [ <a 
		href="delete_site.php?<?=session_name()?>=<?=session_id()?>&amp;dbtable=links&amp;ID=<?
		
		echo $rows[ID];
		
		if(isset($p)){
			echo "&amp;p=" . $p;
		}
		?>">Delete Site</a> ] [ <a href="javascript:window.close();">Close Window</a> ]</td><?
					}?>
			</tr>
			</table>
			</td>
	</tr>
	<tr>
		<td class="text">Site Name: </td>
		<td><input class="small" type="text" name="SiteName" 
		value="<?=stripslashes($rows[SiteName])?>" size="35"></td>
	</tr>
	<tr>
		<td class="text">Site URL: </td>
		<td class="text"><input class="small" type="text" name="SiteURL" 
		value="<?=$rows[SiteURL]?>" size="35"></td>
	</tr>
	<tr>
		<td class="text">Description: </td>
		<td><textarea class="small" name="Description" rows="7" 
		cols="40" wrap="virtual"><?=stripslashes($rows[Description])?></textarea></td>
	</tr>
	<tr>
		<td class="text">Category: </td>
		<td><select class="small" name="Category"><?
			drop_cats($rows[Category], 0, "", $cats);
			echo $cats;
		?></select></td>
	</tr>
	<tr>
		<td class="text">Country: </td>
		<td><select class="small" name="Country"><?
		if($d = dir("../images/flags")){
			echo getFlagList("../images/flags", $rows[Country]);
		}
		?></select></td>
	</tr>
	<tr>
		<td class="text">Email</td>
		<td><input class="small" type="text" name="Email" value="<?=$rows[Email]?>" 
		size="35"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="button" type="submit" name="update" 
		value=" Update Site "></td>
	</form></tr></table><?

}

if(!isset($ID) && !isset($update)){
	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
	<form method="post" action="edit_site.php?<?=session_name()?>=<?=session_id()?>">
		<td class="theader">Please enter a site ID: 
		<input class="small" type="text" name="ID" size="5">
		<input class="button" type="submit" name="submit" value=" Edit Site "></td>
	</form></tr>
	</table><?
}
?>
</body>
</html>
