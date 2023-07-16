<?
// *******************************************************************
//  admin/validate.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");
include("../include/lang/$language.php");
include("../include/session.php");
include("../include/common.php");
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
<?=$adm_body?><?

if(isset($validate_site) && isset($ID)){
	
	$insert = sql_query("
		insert into $tb_links (
			ID,
			SiteName,
			SiteURL,
			Description,
			Category,
			Country,
			Email,
			LastUpdate,
			Added,
			UserName,
			Password,
			Hint
		) values (
			'',
			'$SiteName',
			'$SiteURL',
			'$Description',
			'$Category',
			'$Country',
			'$Email',
			now()+0,
			now()+0,
			'$UserName',
			'$Password',
			'$Hint'
		)"
	);

	$id = sql_insert_id();

	$delete = sql_query("
		delete from
			$tb_temp
		where
			ID='$ID'
	");

	if($email_addition == "Y"){
		include("../include/email_confirmation.php");
	}

?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<td class="theader" align="center">Site has been validated.<br /><br /><?

		$temp_sites = sql_query("
			select
				*
			from
				$tb_temp
		");

		if(sql_num_rows($temp_sites)>0){
			?><a 
			href="sites_main.php?<?=session_name()?>=<?=session_id()?>&amp;submit=1&amp;Category=-1">Validate More Sites</a><?
		} else {
			?><a 
			href="main.php?<?=session_name()?>=<?=session_id()?>&amp;submit=1&amp;Category=-1">No More Sites to Validate</a><?
		}
		?></td>
	</tr>
	</table>
	
	<br /><?
	}

if(isset($ID) && !isset($validate_site))
{
	$get_site = sql_query("select * from $tb_temp where ID='$ID'");
	$rows = sql_fetch_array($get_site);
	?>
	<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<form method="post" action="validate.php?<?=session_name()?>=<?=session_id()?>">
		<input type="hidden" name="UserName" value="<?=$rows[UserName]?>">
		<input type="hidden" name="Password" value="<?=$rows[Password]?>">
		<input type="hidden" name="Hint" value="<?=$rows[Hint]?>">
		<input type="hidden" name="ID" value="<?=$rows[ID]?>">
		<td colspan="2" class="theader"><table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="theader">Validate Site</td>
			<td align="right">[ <a href="<?=$rows[SiteURL]?>" target="_blank">View Site</a> ] [ <a href="delete_site.php?<?=session_name()?>=<?=session_id()?>&amp;table=temp&amp;ID=<?=$rows[ID]?>">Delete</a> ]</td>
		</tr>
		</table></td>
	</tr>
	<tr>
		<td class="text">Site Name:</td>
		<td><input class="small" class="small" type="text" name="SiteName" 
		value="<?=stripslashes($rows[SiteName])?>" size="35"></td>
	</tr>
	<tr>
		<td class="text">Site URL:</td>
		<td><input class="small" type="text" name="SiteURL" 
		value="<?=$rows[SiteURL]?>" size="35"></td>
	</tr>
	<tr>
		<td class="text">Description:</td>
		<td><textarea class="small" name="Description" rows="7" 
		cols="40"><?=stripslashes($rows[Description])?></textarea></td>
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
		<td><select class="small" class="textBox" name="Country"><?
		if($d = dir("../images/flags"))
		{
			echo getFlagList("../images/flags", $rows[Country]);
		}
		?></select></td>
	</tr>
	<tr>
		<td class="text">Email</td>
		<td><input class="small" type="text" name="Email" 
		value="<?=$rows[Email]?>" size="35"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="button" type="submit" 
		name="validate_site" value=" Validate Site "></td>
	</form></tr>
	</table>
	<?
}

if(!isset($ID) && !isset($validate_site))
{
	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<form method="post" action="validate.php?<?=session_name()?>=<?=session_id()?>">
		<td class="theader">Please enter a site ID: <input class="small" type="text" name="ID" size="5">
		<input class="button" type="submit" name="submit" value=" Validate Site "></td>
		</form>
	</tr>
	</table><?
}
?>
</body>
</html>
