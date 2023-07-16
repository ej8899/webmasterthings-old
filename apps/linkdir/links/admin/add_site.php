<?
// *******************************************************************
//  admin/add_site.php
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
<?
if(isset($add)){
	?><META
		HTTP-EQUIV="Refresh"
		CONTENT="1; URL=add_site.php?<?=session_name()?>=<?=session_id()?>"><?
}
?>
</head>
<?=$adm_body?>
<?

if(isset($add))
{
	$result = sql_query("
		insert into
			$tb_links (
				ID, 
				SiteName,
				SiteURL,
				Description,
				Category,
				Country,
				Email,
				UserName,
				Password,
				Hint,
				Added,
				LastUpdate
			)
			values (
				'',
				'$SiteName',
				'$SiteURL',
				'$Description',
				'$Category',
				'$Country',
				'$Email',
				'$UserName',
				password('$Password'),
				'$Hint',
				now()+0,
				now()+0
			)
		");

	?>
	<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<td class="theader" align="center">Site Has been added.<br /><br /><a href="add_site.php?<?=session_name()?>=<?=session_id()?>">Click Here to Continue</a></td>
	</tr>
	</table>
	<br>
<?
} else {
	?>
	<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr><form method="post" action="add_site.php?<?=session_name()?>=<?=session_id()?>">
		<td colspan="2" class="theader">Add Site Manually<br />
		<span class="transtext">No validation is performed, but duplicate URLs will not 
		be added<br>due to unique key associated with SiteURL field 
		in <?=$tb_links?> table.</span></td>
	</tr>
	<tr>
		<td class="text">Site Name: </td>
		<td><input class="small" type="text" name="SiteName" size="35"></td>
	</tr>
	<tr>
		<td class="text">Site URL: </td>
		<td><input class="small" type="text" name="SiteURL" size="35"></td>
	</tr>
	<tr>
		<td class="text">Description: </td>
		<td><textarea class="small" name="Description" rows="7" cols="40" wrap="virtual"></textarea></td>
	</tr>
	<tr>
		<td class="text">Category: </td>
		<td><select class="small" name="Category"><?
		
		drop_cats($rows[Category], 0, "", $cats);
		echo $cats;
		
		?></select></td>
	</tr>
	<tr>
		<td class="text"><?=$add_46?></td>
		<td><select class="small" name="Country">
		<option value="">Please Select</option><?
		if(!isset($Country)){
			$Country = $default_country;
		}
		if($d = dir("../images/flags")){
			echo getFlagList("../images/flags", $Country);
		}
		?></select></td>
	</tr>
	<tr>
		<td class="text">Email</td>
		<td><input class="small" type="text" name="Email" size="35" 
		value="<?=$prefill_email?>"></td>
	</tr>
	<tr>
		<td class="text">UserName: </td>
		<td><input class="small" type="text" name="UserName" size="16" 
		value="<?=$prefill_username?>"></td>
	</tr>
	<tr>
		<td class="text">Password: </td>
		<td><input class="small" type="text" name="Password" size="16" 
		value="<?=$prefill_password?>"></td>
	</tr>
	<tr>
		<td class="text">Password Hint: </td>
		<td><input class="small" type="text" name="Hint" size="16" 
		value="<?=$prefill_hint?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="button" type="submit" name="add" 
		value=" Add Site "></td>
	</form></tr>
	</table>
	<?
}
?>
</body>
</html>
