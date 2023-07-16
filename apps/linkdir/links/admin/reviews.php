<?
// *******************************************************************
//  admin/reviews.php
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
if(isset($validate_review) && isset($ID)){
	
	if($action=="validate"){
		
		$update = sql_query("
			update
				$tb_reviews
			set
				Status='Show',
				ReviewTitle='$ReviewTitle',
				Review='$Review',
				Reviewer='$Reviewer',
				ReviewerURL='$ReviewerURL',
				ReviewerEmail='$ReviewerEmail'
			where
				ID='$ID'
		");
}

if($action=="hide"){
	
	$update = sql_query("
		update
			$tb_reviews
		set
			Status='Hide',
			ReviewTitle='$ReviewTitle',
			Review='$Review',
			Reviewer='$Reviewer',
			ReviewerURL='$ReviewerURL',
			ReviewerEmail='$ReviewerEmail'
		where
			ID='$ID'
	");
}

if($action == "delete"){
	
	$update = sql_query("
		delete from
			$tb_reviews
		where
			ID='$ID'
	");
}

?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<tr>
	<td class="theader" align="center">Site Review has been <?
	
	switch($action){
		case "validate" :
			echo "validated";
			break;
		case "delete" :
			echo "deleted";
			break;
		case "hidden" : 
			echo "hidden";
			break;
	}
	
	?>.<?

	$new_reviews = sql_query("
		select
			*
		from
			$tb_reviews
		where
			Status='New'
	");

	if(
		(sql_num_rows($new_reviews)>0) &&
			!isset($ReturnID)
	){
		?><br /><br /><a href="reviews.php?<?=session_name()?>=<?=session_id()?>">Validate New Site Reviews</a><?
	}
	
	if(isset($ReturnID)){
		?><br />
		<br />
		<a href="reviews.php?<?=session_name()?>=<?=session_id()?>&amp;SiteID=<?=$ReturnID?>">Return to Site Reviews</a><?
	}

	?></td>
</tr>
</table>
<br /><?

}

if(isset($ID) && !isset($validate_review)){
	
	$get_review = sql_query("
		select
			*
		from
			$tb_reviews
		where
			ID='$ID'
	");

	$rows = sql_fetch_array($get_review);
	
	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<form method="post" action="reviews.php?<?=session_name()?>=<?=session_id()?>">
		<input type="hidden" name="ID" value="<?=$ID?>"><?
		
		if(isset($ReturnID)){
			
			?><input type="hidden" name="ReturnID" value="<?=$ReturnID?>"><?
		}
		
		?><td colspan="2" class="theader">Edit Site Review for <?
		
		$gsn = sql_query("
			select
				SiteName,
				SiteURL
			from
				$tb_links
			where
				ID='$rows[SiteID]'
		");

		$gsnr = sql_fetch_array($gsn);
		
		?><a href="<?=$gsnr[SiteURL]?>"
		target="_blank"><?=$gsnr[SiteName]?></a></td>
	</tr>
	<tr>
		<td class="text">Site Review Title: </td>
		<td><input class="small" type="text" name="ReviewTitle"
		value="<?=$rows[ReviewTitle]?>" size="35"></td>
	</tr>
	<tr>
		<td class="text">Review: </td>
		<td><textarea class="small" name="Review" rows="7"
		cols="40"><?=$rows[Review]?></textarea></td>
	</tr>
	<tr>
		<td class="text">Reviewer: </td>
		<td><input class="small" type="text" name="Reviewer" value="<?=$rows[Reviewer]?>"
		size="35"></td>
	</tr>
	<tr>
		<td class="text">Reviewer Site URL: </td>
		<td><input class="small" type="text" name="ReviewerURL"
		value="<?=$rows[ReviewerURL]?>" size="35"></td>
	</tr>
	<tr>
		<td class="text">Reviewer Email: </td>
		<td><input class="small" type="text" name="ReviewerEmail"
		value="<?=$rows[ReviewerEmail]?>" size="35"></td>
	</tr>
	<tr>
		<td class="text">Validate: </td>
		<td class="text" nowrap="nowrap"><input class="small" type="radio" name="action" value="validate" <?
		if(
			($rows[Status]=="New") ||
			($rows[Status]=="Show")
		){
			echo " checked";
		}
		
		?>> Validate <input class="small" type="radio" name="action" value="delete"> Delete 
		<input type="radio" name="action" value="hide" <?
		if($rows[Status]=="Hide"){
			echo " checked";
		}
		?>> Hide</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="button" type="submit"
		name="validate_review" value=" Validate Site Review "></td>
	</form></tr>
	</table>
	<?
}

if(
	!isset($ID) &&
	!isset($validate_review) &&
	!isset($SiteID)
){
	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<td class="theader">Site Name</td>
		<td class="theader">Site Review Title</td>
		<td class="theader">Validate</td>
	</tr><?

	$get_reviews = sql_query("
		select
			*
		from
			$tb_reviews
		where
			Status='New'
	");

	if(sql_num_rows($get_reviews)>0){

		while($rows = sql_fetch_array($get_reviews)){
			
			?><tr>
				<td class="text"><?

				$gsn = sql_query("
					select
						SiteName
					from
						$tb_links
					where
						ID='$rows[SiteID]'
				");

				$gsnr = sql_fetch_array($gsn);

				echo $gsnr[SiteName];
			?></td>
				<td class="text"><?=$rows[ReviewTitle]?></td>
				<td><a href="reviews.php?<?=session_name()?>=<?=session_id()?>&amp;ID=<?=$rows[ID]?>">Validate</a></td>
			</tr><?
		}
	} else {
		
		?><tr>
			<td colspan="3" class="text">Sorry, no site reviews to validate.  <a href="javascript:history.go(-1)">Go Back</a></td>
		</tr><?
	}

	?></table><?
}

if(isset($SiteID)){
	
	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr>
		<td class="theader">Site Name</td>
		<td class="theader">Site Review Title</td>
		<td class="theader">Status</td>
		<td class="theader">Validate</td>
	</tr><?

	$get_reviews = sql_query("
		select
			*
		from
			$tb_reviews
		where
			SiteID='$SiteID'
		and
			Status='Show'
		or
			Status='Hide'
	");

	if(sql_num_rows($get_reviews)>0){

		while($rows = sql_fetch_array($get_reviews)){
			?><tr>
				<td class="text"><?

				$gsn = sql_query("
					select
						SiteName
					from
						$tb_links
					where
						ID='$rows[SiteID]'
				");

				$gsnr = sql_fetch_array($gsn);
				
				echo $gsnr[SiteName];
			
				?></td>
				<td class="text"><?=$rows[ReviewTitle]?></td>
				<td class="text"><?=$rows[Status]?></td>
				<td class="text"><a 
				href="reviews.php?<?=session_name()?>=<?=session_id()?>&amp;ID=<?=$rows[ID]?>&ReturnID=<?=$SiteID?>">
				Validate</a></td>
			</tr><?
		}
	} else {
	
		?><tr>
			<td colspan="4" class="text">Sorry, no site reviews for this site.  
			<a href="javascript:history.go(-1)"><-- Back</a></td>
		</tr><?
	}
	?></table><?
}
?>
</body>
</html>
