<?
// *******************************************************************
//  admin/main.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");

include("../include/common.php");
$language = $gl["Language"];

include("../include/lang/$language.php");

include("../include/session.php");
// // tcm remove php warning
// session_start();

$temp = sql_query("
	select
		*
	from
		$tb_temp
");

$reviews = sql_query("
	select
		*
	from
		$tb_reviews
	where
		Status='New'
");

$sites = sql_query("
	select
		count(*) as count
	from
		$tb_links
");
$sites_array = sql_fetch_array($sites);

$categories = sql_query("
	select
		count(*) as count
	from
		$tb_categories
");
$categories_array = sql_fetch_array($categories);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
	<title></title>
	<link rel = "stylesheet" type = "text/css" href = "style.css" />
</head>
<?=$adm_body?>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td class="title">Main Page</td>
</tr>
<tr>
	<td class="text">
	You have <?=sql_num_rows($temp)?> new sites to <a href="sites.php?<?=session_name()?>=<?=session_id()?>">validate</a>.
	<br />
	You have <?=sql_num_rows($reviews)?> new site reviews to <a href="reviews.php?<?=session_name()?>=<?=session_id()?>">validate</a>.
	<br />
	You have <?=$sites_array["count"]?> total sites. <a href="sites.php?<?=session_name()?>=<?=session_id()?>">Edit Sites</a>.
	<br />
	You have <?=$categories_array["count"]?> total categories. <a href="categories.php?<?=session_name()?>=<?=session_id()?>">Edit Categories</a>.
	<br />
	<?
		$rel_query = sql_query("
		select
			$tb_categories.ID as cat_id
		from
			$tb_categories
		left join
			$tb_related
		on
			$tb_categories.ID=$tb_related.cat_id
		where
			$tb_related.cat_id is null
		and
			$tb_categories.PID != '0'
		order by
			$tb_categories.ID
	");
	$rel_count = sql_num_rows($rel_query);

	?>
	<? if($rel_count>0){?>You have <?=($rel_count+0)?> <a href="unrelated.php?<?=session_name()?>=<?=session_id()?>">unrelated categorie<? if($rel_count != 1){ echo "s";}?></a>.
	<br /><?}?>
	<?
	$sql = sql_query("
		select
			count(*) as count
		from
			$tb_sessions
		where
			expire > UNIX_TIMESTAMP() - 300
		");
	$rows = sql_fetch_array($sql);
	?>
	There <? if($rows["count"] != 1 ){ echo "are";} else { echo "is"; }?> <?=($rows["count"]+0)?> visitor<? if($rows["count"]!=1){ echo "s";}?> online including yourself.
	</td>
</tr>
</table>
<br />
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td class="title">
	Help fund phpLinks development:
	<!-- Begin PayPal Logo -->
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="gearstore@huntseek.com">
	<input type="hidden" name="item_name" value="NewPHPLinks">
	<input type="hidden" name="item_number" value="1">
	<input type="hidden" name="no_shipping" value="1">
	<input type="image" src="../images/x-click-but21.gif" border="0" name="submit" alt="Make a donation to the phpLinks cause with PayPal - it's fast, free and secure!" title="Make a donation to the phpLinks cause with PayPal - it's fast, free and secure!">
	</form>
	<!-- End PayPal Logo --></td>
</tr>
</table>
		
</body>
</html>
