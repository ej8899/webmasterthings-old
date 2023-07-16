<?
// *******************************************************************
//  admin/delete_category.php
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
<?=$adm_body?><?

if(isset($ID) && isset($sure)){
	
	if($dbtable == "links"){
		
		$sql = "
			delete from
				$tb_links
			where
				ID='$ID'
		";

	} else {

		$sql = "
			delete from
				$tb_temp
			where
				ID='$ID'
		";
		
		if($email_deletion == "Y"){
			include("../include/email_deletion.php");
		}
	}
	
	$delete = sql_query($sql);

?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<td align="center" class="theader">Site has been Deleted.<?
		
		if(!isset($dupes)){
			
			$temp_sites = sql_query("select * from $tb_temp");
			
			if(sql_num_rows($temp_sites)>0){
				?><br><br><a href="sites_main.php?<?=session_name()?>=<?=session_id()?>&amp;submit=1&amp;Category=-1">
				Validate More Sites</a><?
			}

		} else {
			?><br><br><a href="dupes.php?<?=session_name()?>=<?=session_id()?>">Remove More Duplicates</a><?
		}
		?></td>
	</tr>
	</table>
	<br><?
	
	if(isset($p) && $p=1){
		?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
		<tr>
			<td align="center"><a href="javascript:window.close();">Close Window</a></td>
		</tr>
		</table>
		<br><?
	}
}

if(isset($notsure)){
	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<td align="center" class="theader">Site has not been Deleted.<?
			if(!isset($dupes)){
				
				$temp_sites = sql_query("
					select
						*
					from
						$tb_temp
				");
				
				if(sql_num_rows($temp_sites)>0){
					?><br><br><a href="sites_main.php?<?=session_name()?>=<?=session_id()?>&amp;submit=1&amp;Category=-1">
						Validate More Sites</a><?
				}
			} else {
				?><br><br><a href="dupes.php?<?=session_name()?>=<?=session_id()?>">Remove More Duplicates</a><?
			}
			?></td>
	</tr>
	</table>
	<br><?
}

if(isset($ID) && !isset($notsure) && !isset($sure)){

	if($dbtable == "links"){
		
		$sql = "
			select
				*
			from
				$tb_links
			where
				ID='$ID'
		";

	} else {

		$sql = "
			select
				*
			from
				$tb_temp
			where
				ID='$ID'
		";
	}

$get_cat = sql_query($sql);
$rows = sql_fetch_array($get_cat);

?><form method="post" action="delete_site.php?<?=session_name()?>=<?=session_id()?>">
	<input type="hidden" name="ID" value="<?=$ID?>"><?
	
	if(isset($p))	{
		?>	<input type="hidden" name="p" value="<?=$p?>"><?
	}

	if(isset($dupes)){
		?><input type="hidden" name="dupes" value="<?=$dupes?>"><?
	}

	?><input type="hidden" name="dbtable" value="<?=$dbtable?>">
		<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
		<tr>
			<td align="center" class="theader">Are you sure you want to delete site with ID 
			<?=$rows[ID]?>?<br><br><input type="submit" name="sure" value="Yes">
			&nbsp;<input type="submit" name="notsure" value="No"></td>
		</tr>
		</table>
		</form><?
	}

	if(!isset($ID)){
	
		?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
			<tr><form method="post" action="delete_site.php?<?=session_name()?>=<?=session_id()?>">
				<td align="center">Please enter a site ID to delete: 
				<input class="small" type="text" name="ID" size="5">&nbsp;
				<input class="button" type="submit" name="delete" value="Delete Site"></td>
			</form></tr>
			</table><?
	}
?></body>
</html>
