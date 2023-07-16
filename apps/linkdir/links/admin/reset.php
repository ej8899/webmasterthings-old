<?
// *******************************************************************
//  admin/reset.php
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
<tr>
	<td colspan="2" class="theader">Reset Database Values</td>
</tr><?

if(isset($submit)){
	
	if(isset($reset_in)){
		
		$sql = sql_query("
			alter table
				$tb_links
			drop
				HitsIn
		");

		$sql = sql_query("
			alter table
				$tb_links
			add
				HitsIn int(7) unsigned default '0' not null
		");

		$html .= "<tr><td class=\"text\">Hits In have been reset.</td></tr>";
	}

	if(isset($reset_out)){

		$sql = sql_query("
			alter table
				$tb_links
			drop
				HitsOut
		");

		$sql = sql_query("
			alter table
				$tb_links
			add
				HitsOut int(7) unsigned default '0' not null
		");

		$html .= "<tr><td class=\"text\">Hits Out have been reset.</td></tr>";
	}

	if(isset($search_terms)){
		
		$sql = sql_query("
			delete from $tb_terms
		");

		$html .= "<tr><td class=\"text\">Search Terms have been reset.</td></tr>";
	}

	if(isset($referrers)){
		
		$sql = sql_query("
			alter table
				$tb_links
			drop
				InIP
		");

		$sql = sql_query("
			alter table
				$tb_links
			drop
				OutIP
		");

		$sql = sql_query("
			alter table
				$tb_links
			add
				InIP varchar(15) not null
		");

		$sql = sql_query("
			alter table
				$tb_links
			add
				OutIP varchar(15) not null
		");

		$html .= "<tr><td class=\"text\">All Referrer IPs have been reset.</td></tr>";
	}

	if(!isset($reset_in) && !isset($reset_out) && !isset($search_terms) && !isset($referrers)){
		$html .= "<tr><td class=\"text\">Nothing has been reset.</td></tr>";
	}

	echo $html;
} else {
	?><tr><form method="post" action="reset.php?<?=session_name()?>=<?=session_id()?>">
		<td width="99%" class="text">Reset Hit In:<br />This will reset all HitsIn counts to zero for all sites.</td>
		<td width="1%"><input class="small" type="checkbox" name="reset_in"></td>
	</tr>
	<tr>
		<td class="text">Reset Hits Out:<br />This will reset all HitsOut counts to zero for all sites.</td>
		<td><input class="small" type="checkbox" name="reset_out"></td>
	</tr>
	<tr>
		<td class="text">Reset Search Terms:<br />This will delete all recorded search terms.</td>
		<td><input class="small" type="checkbox" name="search_terms"></td>
	</tr>
	<tr>
		<td class="text">Reset Referrer IPs<br />This will reset all incoming and outgoing Referrer IPs.</td>
		<td><input class="small" type="checkbox" name="referrers"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="button" type="submit" 
		name="submit" value="Reset Values"></td>
	</form></tr><?
}
?>
</table>
</body>
</html>
