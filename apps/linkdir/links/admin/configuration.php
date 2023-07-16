<?
// *******************************************************************
//  admin/configuration.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");
include("../include/common.php");

$language = $gl["Language"];

include("../include/lang/$language.php");

include("../include/session.php");
// // tcm remove php warning
// session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<title></title>
<link rel = "stylesheet" type = "text/css" href = "../../../public_html/admin/style.css" />
</head>
<?=$adm_body?>
<?
if(isset($submit)){
	
	$update = sql_query("../../../public_html/admin/
		update
			$tb_settings
		set
			SiteTitle				=	'$SiteTitle',
			Name				=	'$Name',
			Email				=	'$Email',
			DateFormat			=	'$DateFormat',
			DefaultCountry		=	'$DefaultCountry',
			ColCount				=	'$ColCount',
			ManuallyValidate		=	'$ManuallyValidate',
			URLValidate			=	'$URLValidate',
			NewSubmissionEmail	=	'$NewSubmissionEmail',
			SiteAdditionEmail		=	'$SiteAdditionEmail',
			SiteDeletionEmail		=	'$SiteDeletionEmail',
			PerPage				=	'$PerPage',
			NavLinks				=	'$NavLinks',
			BaseURL			=	'$BaseURL',
			BasePath			=	'$BasePath',
			Theme				=	'$theme',
			Language			=	'$language',
			OuterFrame			=	'$OuterFrame'
		where
			ID='1'
	");
}

$gl_query = sql_query("
	select
		*
	from
		$tb_settings
	where
		ID='1'
");

$gl = sql_fetch_array($gl_query);
?>
	<form action="configuration.php?<?=session_name()?>=<?=session_id()?>" method="post">
		<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
		<tr>
			<td colspan="2" class="theader">Site Configuration<? if(isset($submit)){ ?> - Update Complete<?}?></td>
		</tr>
		<tr>
			<td valign="top" class="text">BaseURL:<br /><span class="small">Base URL for 
			your site, no trailing slash please.  </span></td>
			<td class="text"><input class="small" type="text" name="BaseURL" value="<?=$gl[BaseURL]?>" 
			size="30" /></td>
		</tr>
		<tr>
			<td valign="top" class="text">Base Path:<br /><span class="small">Base Path 
			for the phpLinks files on your server, no trailing slash 
			please.</span></td>
			<td class="text"><input class="small" type="text" name="BasePath" value="<?=$gl[BasePath]?>" 
			size="30" /></td>
		</tr>
		<tr>
			<td valign="top" class="text">Site Title:<br /><span class="small">Site Title 
			is what you want as the Title on the top of each page.  (example: 
			Bob's Search Engine)</span></td>
			<td class="text"><input class="small" type="text" name="SiteTitle" 
			value="<?=$gl["SiteTitle"]?>" size="30" /></td>
		</tr>
		<tr>
			<td valign="top" class="text">Site Owner Name:<br /><span class="small">Site 
			Owner Name should be your name, or your company name. (example: 
			Alfred E. Newman, Inc.)</span></td>
			<td class="text"><input class="small" type="text" name="Name" value="<?=$gl["Name"]?>" 
			size="30" /></td>
		</tr>
		<tr>
			<td valign="top" class="text">Site Owner Email:<br /><span class="small">Site 
			Owner Email should be the email address of the Site Owner. 
			(example: fred@aol.com)</span></td>
			<td class="text"><input class="small" type="text" name="Email" value="<?=$gl["Email"]?>" 
			size="30" /></td>
		</tr>
        <tr>
			<td valign="top" class="text">Date Format:<br /><span class="small">Date Format is for how you want the "Added" and "Last Updated" links to be formatted.<br /><br />Here are some popular choices:<br />M j, Y = August 10, 1972<br />m-d-y = 08-10-72<br /><br />For more info on date formatting see the manual: <a href="http://php.net/date" target="_blank">http://php.net/date</a></span></td>
			<td class="text"><input class="small" type="text" name="DateFormat" value="<?=$gl["DateFormat"]?>" size="30" /></td>
        </tr>
        <tr>                                                                                                                
            <td valign="top" class="text">Default Country:<br /><span class="small">Select the default country for your Add Site page.</span></td>
			<td class="text"><?
				echo "<select class=\"small\" name=\"DefaultCountry\"><option ";
				echo "value=\"\">" . $add_47 . "</option>";                                                                                               
				if($d = dir("../../../public_html/images/flags")){
					echo getFlagList("../../../public_html/images/flags", $gl["DefaultCountry"]);
				}

				echo "</select>";
			?></td>                                                                                           
        </tr>
		<tr>
			<td valign="top" class="text">phpLinks Theme:<br /><span class="small">Select 
			the look and feel of your phpLinks.</span></td>
			<td class="text">
				<select class="small" name="theme"><?
					$theme = $gl["Theme"];

					if($d = dir("../../../public_html/themes")){
						getDirList("../../../public_html/themes");
					}
				?></select>
			</td>
		</tr>
        <tr>
             <td valign="top" class="text">Default Language:<br /><span class="small">Select the default language for your phpLinks.</span></td>
             <td class="text"><select class="small" name="language"><?
					$language = $gl["Language"];

					if($d = dir("../../../public_html/include/lang")){
							getLangList("../../../public_html/include/lang");
					}
             ?></select></td>
        </tr>
	<tr>
		<td valign="top" class="text">
			Validate Sites Manually:
			<br />
			<span class="small"../../../public_html/admin/>You may validate sites manually, meaning you must approve each submission before it will appear on the site, and submissions will be sent to the 'temp' table when first submitted.  Or you may allow site submissions to bypass the manual validation process and be directly addded to your 'links' table when first submitted.</span>
		</td>
		<td class="text">
			<select class="small" name="ManuallyValidate"><?
				echo "<option value=\"Y\"";

				if($gl[ManuallyValidate] == "Y"){
					
					echo " selected=\"selected\"";
				}

				echo ">Yes</option><option value=\"N\"";

				if($gl[ManuallyValidate] == "N"){
					
					echo " selected=\"selected\"";
				}

				echo ">No</option>";	
			?></select>
			</td>
		</tr>	
		<tr>
			<td valign="top" class="text">Validate URLs Automatically:<br />
			<span class="small">This contols whether add.php attempts to 
			<i>fopen()</i> the submitted URL or not.  Do not set this to Yes if 
			you plan to allow FTP server submissions, they will fail 
			otherwise.  Do not set this to Yes if your webserver is under heavy 
			load, the add.php may take a long time to return.</span></td>
			<td class="text">
				<select class="small" name="URLValidate"><?
					echo "<option value=\"Y\"";
					
					if($gl[URLValidate] == "Y"){

						echo " selected=\"selected\"";
					}
					
					echo ">Yes</option><option value=\"N\"";
					
					if($gl[URLValidate] == "N"){

						echo " selected=\"selected\"";
					}
					
					echo ">No</option>";
					
				?></select>
			</td>
		</tr>	
		<tr>
			<td valign="top" class="text">Send E-Mail on Site Addition:<br />
			<span class="small">Select whether you wish to have email sent to each 
			site owner if their site is validated and added to the database.  
			This is automatically off if you do not Validate Sites 
			Manually.</span></td>
			<td class="text">
				<select class="small" name="SiteAdditionEmail"><?

					echo "<option value=\"Y\"";

					if($gl[SiteAdditionEmail] == "Y"){

						echo " selected=\"selected\"";
					}

					echo ">Yes</option><option value=\"N\"";

					if($gl[SiteAdditionEmail] == "N"){

						echo " selected=\"selected\"";
					}

					echo ">No</option>";

				?></select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="text">Send E-Mail on Site Deletion:<br />
			<span class="small">Select whether you wish to have email sent to each 
			site owner if their site is validated and deleted from the 
			database.  This is automatically off if you do not Validate Sites 
			Manually.</span></td>
			<td class="text">
				<select class="small" name="SiteDeletionEmail"><?
					echo "<option value=\"Y\"";
					
					if($gl[SiteDeletionEmail] == "Y"){

						echo " selected=\"selected\"";
					}

					echo ">Yes</option><option value=\"N\"";
					
					if($gl[SiteDeletionEmail] == "N"){

						echo " selected=\"selected\"";
					}

					echo ">No</option>";

				?></select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="text">Send E-Mail to you on new Site Submission:
			<br /><span class="small">Select whether you want to recieve e-mail 
			everytime a new site submission occurs.</span></td>
			<td class="text">
				<select class="small" name="NewSubmissionEmail"><?

					echo "<option value=\"Y\"";

					if($gl[NewSubmissionEmail] == "Y"){

						echo " selected=\"selected\"";
					}

					echo ">Yes</option><option value=\"N\"";

					if($gl[NewSubmissionEmail] == "N"){

						echo " selected=\"selected\"";
					}

					echo ">No</option>";

				?></select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="text">Columns:<br /><span class="small">How many main 
			category columns should appear on each page.</span></td>
			<td class="text">
				<select class="small" name="ColCount"><?
					
					for($x=1;$x<5;$x++){

						echo "<option value=\"" . $x . "\"";

						if($gl[ColCount] == $x){

							echo " selected=\"selected\"";
						}

						echo "> " . $x . " </option>";
					}	
				?></select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="text">Navigation Links:<br /><span class="small">How 
			large should the navigation links span on each page.</span></td>
			<td class="text"><input class="small" type="text" name="NavLinks" value="<?=$gl[NavLinks]?>" 
			size="5" /></td>
		</tr>
		<tr>
			<td valign="top" class="text">Links Per Page:<br /><span class="small">How 
			many links should appear on each page.</span></td>
			<td class="text"><input class="small" type="text" name="PerPage" value="<?=$gl[PerPage]?>" 
			size="5" /></td>
		</tr>
		<tr>
			<td valign="top" class="text">
				Use Outer Frame:
				<br />
				<span class="small">Links to outgoing referrers can go into a frameset instead of into a new window.</span>
			</td>
			<td class="text">
				<select class="small" name="OuterFrame"><?
				echo "<option value=\"Y\"";
				if($gl[OuterFrame] == "Y"){echo " selected=\"selected\"";}
				echo ">Yes</option><option value=\"N\"";
				if($gl[OuterFrame] == "N"){echo " selected=\"selected\"";}
				echo ">No</option>";	
				?></select>
			</td>
		</tr>	
		<tr>
			<td colspan="2" align="center" valign="top" class="text"><input class="button" type="submit" 
			name="submit" value=" Update " /></td>
		</tr>
		</table>
	</form>
</body>
</html>
