<?
// *******************************************************************
//  admin/dupes.php
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
		<title>Admin</title>
	</head>
	<?=$adm_body?>
	<table cellspacing="5" cellpadding="5" border="1" align="center">
	<tr bgcolor="#dddddd">
		<td> ID </td>
		<td> Site URL </td>
		<td> Edit </td>
		<td> Delete </td>
	</tr><?
	
	$get_dupes = sql_query("
		select
			SiteURL,
			count(*) as count
		from
			$tb_links
		group by
			SiteURL
		order by
			count desc
		limit
			0,1;
	");

	while($dupes = sql_fetch_array($get_dupes)){
		
		if($dupes[count]>1){
			
			$get_sites = sql_query("
				select
					*
				from
					$tb_links
				where
					SiteURL = '$dupes[SiteURL]'
			");

			while($site = sql_fetch_array($get_sites)){
					
					echo "<tr bgcolor=\"#eeeeee\">";
					echo "<td>" . $site[ID] . "</td>";
					echo "<td>" . $site[SiteURL] . "</td>";
					echo "<td><a href=\"edit_site.php?" . session_name() . "=";
					echo session_id() . "&amp;ID=";
					echo $site[ID] . "&\">Edit</a></td>";
					echo "<td><a href=\"delete_site.php?" . session_name() . "=";
					echo session_id() . "&amp;dbtable=links&amp;dupes=1&amp;ID=";
					echo $site[ID] . "&\">Delete</a></td>";
					echo "</tr>\n";
			}
		} else {
				?><tr><td colspan="4">No Duplicates found.</td></tr><?
		}
	}
	?></table>
</body>
</html>
