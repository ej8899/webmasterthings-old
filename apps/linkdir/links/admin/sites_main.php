<?
// *******************************************************************
//  admin/sites_main.php
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
if(isset($submit)){	
	
	$total_sql = "
		select
			$tb_links.ID as link_id,
			$tb_links.SiteURL as site_url,
			$tb_links.SiteName as site_name,
			$tb_categories.Category as cat_name
		from
			$tb_links
		left join
			$tb_categories
		on
			$tb_categories.ID=$tb_links.Category
		where
			$tb_links.Category='$Category'
	";

	if($Category == "0"){
		
		$total_sql = "
			select
				$tb_links.ID as link_id,
				$tb_links.SiteURL as site_url,
				$tb_links.SiteName as site_name,
				$tb_categories.Category as cat_name
			from
				$tb_links
			left join
				$tb_categories
			on
				$tb_categories.ID=$tb_links.Category
			where
				$tb_links.Category='0'
			or
				$tb_links.Category=''
		";
	}

	if($Category == "-1"){
		
		$total_sql = "
			select
				$tb_temp.ID as link_id,
				$tb_temp.SiteURL as site_url,
				$tb_temp.SiteName as site_name,
				'' as cat_name
			from
				$tb_temp
		";
	}

	$total_result = sql_query($total_sql);
	$total_sites = sql_num_rows($total_result);
	$pp=30;
	$np=4;

	if(!isset($cp)){
		$cp=0;
	}

	if(!isset($sr)){
		$sr=0;
	}

	$nav_url = "sites_main.php?Category=" . $Category . "&submit=1i&";

	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%"><?
	echo "<tr><td class=\"theader\" colspan=\"";

	if($Category > 0){
		echo "5";
	} else {
		echo "4";
	}

	echo "\">". nav_links($total_sites, $pp, $np, $cp, $nav_url) . "</td></tr>";
	echo "<tr bgcolor=\"#EEEEEE\"><td class=\"theader\">Site Name</td>";

	if($Category > "0"){
		
		echo "<td class=\"theader\">Category</td>";
	}

	echo "<td class=\"theader\">";

	if($Category == "-1"){
		echo "Validate";
	} else {
		echo "Edit";
	}

	echo "</td><td class=\"theader\">Reviews</td><td class=\"theader\">Delete</td></tr>";
	
	$sql = "
		select
			$tb_links.ID as link_id,
			$tb_links.SiteURL as site_url,
			$tb_links.SiteName as site_name,
			$tb_categories.Category as cat_name
		from
			$tb_links
		left join
			$tb_categories
		on
			$tb_categories.ID=$tb_links.Category
		where
			$tb_links.Category='$Category'
		limit
			$sr, $pp
	";

	if($Category == "0"){
		
		$sql = "
			select
				$tb_links.ID as link_id,
				$tb_links.SiteURL as site_url,
				$tb_links.SiteName as site_name,
				$tb_categories.Category as cat_name
			from
				$tb_links
			left join
				$tb_categories
			on
				$tb_categories.ID=$tb_links.Category
			where
				$tb_links.Category='0'
			or
				$tb_links.Category=''
			limit
				$sr, $pp
		";
	}

	if($Category == "-1"){
		
		$sql = "
			select
				$tb_temp.ID as link_id,
				$tb_temp.SiteURL as site_url,
				$tb_temp.SiteName as site_name,
				'' as cat_name
			from
				$tb_temp
			limit
				$sr, $pp
		";
	}

	$result = sql_query($sql);

	while($rows = sql_fetch_array($result)){

		echo "<tr><td><a href=\"" . $rows[site_url] . "\" target=\"_blank\">";
		echo stripslashes($rows[site_name]) . "</a></td>";

		if($Category > "0"){
			
			echo "<td class=\"text\">" . eregi_replace("_", " ", $rows[cat_name]) . "</td>";
		}

		echo "<td>";
		
		if($Category == "-1"){
			
			echo "<a href=\"validate.php?" . session_name() . "=" . session_id();
			echo "&amp;ID=" . $rows[link_id];
			echo "\">Validate</a>";
		} else {
			
			echo "<a href=\"edit_site.php?" . session_name() . "=" . session_id();
			echo "&amp;ID=" . $rows[link_id];
			echo "\">Edit</a>";
		}

		echo "</td><td><a href=\"reviews.php?" . session_name() . "=";
		echo session_id() . "&amp;SiteID=" . $rows[link_id];
		echo "\">Reviews</a></td><td><a href=\"delete_site.php?";
		echo session_name() . "=" . session_id() . "&amp;dbtable=";
		
		if($Category >= "0"){
			
			echo "links";
		} else {
			
			echo "temp";
		}

		echo "&amp;ID=" . $rows[link_id] . "\">Delete</a></td></tr>";
	}
	
	echo "</table>";
}
?>
</body>
</html>
