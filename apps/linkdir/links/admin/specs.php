<?
// *******************************************************************
//  admin/specs.php
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
	
	$update = sql_query("
		update
			$tb_specs
		set
			SiteNameMin = '$SiteNameMin',
			SiteNameMax = '$SiteNameMax',
			DescMin = '$DescMin',
			DescMax = '$DescMax',
			UserNameMin = '$UserNameMin',
			UserNameMax = '$UserNameMax',
			PWMin = '$PWMin',
			PWMax = '$PWMax',
			HintMin = '$HintMin',
			HintMax = '$HintMax',
			EmailSpec = '$EmailSpec',
			ReviewTitleMin = '$ReviewTitleMin',
			ReviewTitleMax = '$ReviewTitleMax',
			ReviewerMin = '$ReviewerMin',
			ReviewerMax = '$ReviewerMax',
			ReviewMin = '$ReviewMin',
			ReviewMax = '$ReviewMax',
			ReviewerEmailSpec = '$ReviewerEmailSpec'
		where
			ID='1'
	");
}

$gl_query = sql_query("
	select
		*
	from
		$tb_specs
	where
		ID='1'
");

$gl = sql_fetch_array($gl_query);

?><form action="specs.php?<?=session_name()?>=<?=session_id()?>" method="post">
<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<tr>
	<td colspan="2" class="theader">Site Addition Specifications<? if(isset($submit)){ ?> - Update Complete<?}?></td>
</tr>
<tr>
	<td class="text" valign="top">Site Name Minimum:
	<br /><span class="small">How small a Site Name can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="SiteNameMin"
	value="<?=$gl[SiteNameMin]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Site Name Maximum:
	<br /><span class="small">How large a Site Name can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="SiteNameMax"
	value="<?=$gl[SiteNameMax]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Description Minimum:
	<br /><span class="small">How small a Site Description can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="DescMin"
	value="<?=$gl[DescMin]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Description Maximum:
	<br /><span class="small">How large a Site Description can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="DescMax"
	value="<?=$gl[DescMax]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">UserName Minimum:
	<br /><span class="small">How small a User Name can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="UserNameMin"
	value="<?=$gl[UserNameMin]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">UserName Maximum:
	<br /><span class="small">How large a User Name can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="UserNameMax"
	value="<?=$gl[UserNameMax]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Password Minimum:
	<br /><span class="small">How small a Password can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="PWMin"
	value="<?=$gl[PWMin]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Password Maximum:
	<br /><span class="small">How large a Password can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="PWMax"
	value="<?=$gl[PWMax]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Hint Minimum:
	<br /><span class="small">How small a Password Hint can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="HintMin"
	value="<?=$gl[HintMin]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Hint Maximum:
	<br /><span class="small">How large a Password Hint can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="HintMax"
	value="<?=$gl[HintMax]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Email Regular Expression:
	<br /><span class="small">Validation Expression</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="EmailSpec"
	value="<?=$gl[EmailSpec]?>" size="50" /></td>
</tr>
<tr>
	<td class="theader" colspan="2">Site Review Specifications<? if(isset($submit)){ ?> - Update Complete<?}?></td>
</tr>
<tr>
	<td class="text" valign="top">Review Title Minimum:
	<br /><span class="small">How small a Review Title can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="ReviewTitleMin"
	value="<?=$gl[ReviewTitleMin]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Review Title Maximum:
	<br /><span class="small">How large a Review Title can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="ReviewTitleMax"
	value="<?=$gl[ReviewTitleMax]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Reviewer Name Minimum:
	<br /><span class="small">How small a Reviewer's Name can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="ReviewerMin"
	value="<?=$gl[ReviewerMin]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Reviewer Name Maximum:
	<br /><span class="small">How large a Reviewer's Name can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="ReviewerMax"
	value="<?=$gl[ReviewerMax]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Review Minimum:
	<br /><span class="small">How small a Review can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="ReviewMin"
	value="<?=$gl[ReviewMin]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Review Maximum:
	<br /><span class="small">How large a Review can be.</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="ReviewMax"
	value="<?=$gl[ReviewMax]?>" size="5" /></td>
</tr>
<tr>
	<td class="text" valign="top">Reviewer Email Regular Expression:
	<br /><span class="small">Validation Expression</span></td>
	<td class="text" valign="top"><input class="small" type="text" name="ReviewerEmailSpec"
	value="<?=$gl[ReviewerEmailSpec]?>" size="50" /></td>
</tr>
<tr>
	<td class="text" colspan="2" align="center" valign="top"><input class="button" type="submit"
	name="submit" value=" Update " /></td>
</tr>
</table></form>
</body>
</html>
