<?
// *******************************************************************
//  admin/insert_category.php
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
if(isset($submit)){
	echo "<META NAME=\"REFRESH\" HTTP-EQUIV=\"REFRESH\" content=\"1; ";
	echo "URL=categories_main.php?" . session_name() . "=" . session_id();
	echo "&amp;RPID=" . $RPID . "\">";
}
?></head>
<?=$adm_body?>
<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<?

if(isset($submit)){

?>
<tr>
	<td align="center" class="theader"><?
		
		if(isset($PID)){

			$num_rows = count($Category);

			for($i = 0;$i < $num_rows;++$i){

				if(strlen($Category[$i])  > 0){

					if(strlen($AllowSites[$i]) < 1){
						$AllowSites[$i] = "N";
					}

					if(strlen($ShowSiteCount[$i]) < 1){
						$ShowSiteCount[$i] = "N";
					}

					$insert = sql_query("
						insert into $tb_categories (
							ID,
							Category,
							PID,
							Children,
							TopChildren,
							AllowSites,
							ShowSiteCount,
							Description
						) values (
							'',
							'$Category[$i]',
							'$PID[$i]',
							'$Children[$i]',
							'$TopChildren[$i]',
							'$AllowSites[$i]',
							'$ShowSiteCount[$i]',
							'$Description[$i]'
						)
					");

					echo "Category <b>" . $Category[$i];
					echo "</b> has been added.<br>\n";
				}
			}
		} else {
			
			$num_rows = count($Category);
			
			for($i = 0;$i < $num_rows;++$i){
				
				if(strlen($Category[$i]) > 0){

					if(strlen($AllowSites[$i]) < 1){
						$AllowSites[$i] = "N";
					}

					if(strlen($ShowSiteCount[$i]) < 1){
						$ShowSiteCount[$i] = "N";
					}
					
					$insert = sql_query("
						insert into $tb_categories (
							ID,
							Category,
							PID,
							Children,
							TopChildren,
							AllowSites,
							ShowSiteCount,
							Description
						) values (
							'',
							'$Category[$i]',
							'0',
							'$Children[$i]',
							'$TopChildren[$i]',
							'$AllowSites[$i]',
							'$ShowSiteCount[$i]',
							'$Description[$i]'
						)
					");
					
					echo "Category <b>".$Category[$i]."</b> has been added.<br>\n";
				}
			}
		}
		
		?></td>
	</tr><?
		
	} else {
		
		?><tr>
			<td colspan="2" class="theader">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td class="theader">Insert Categories into <?
					if(isset($PID)){							
						$get_category = @sql_query("
							select
								*
							from
								$tb_categories
							where
								ID='$PID'
						");
						$get_row = @sql_fetch_array($get_category);
					}

					if(isset($get_row[Category])){
						echo eregi_replace("_", " ", $get_row[Category]);
					} else {
						echo "Top Level";
					}

				?><br /><a href="categories_main.php?<?=session_name()?>=<?=session_id()?>">Click Here to Continue.</a></td>
				<form method="post" action="insert_category.php?<?=session_name()?>=<?=session_id()?>">
				<input type="hidden" name="PID" value="<?=$PID?>">
				<input type="hidden" name="RPID" value="<?=$RPID?>">
				<td align="right" class="theader"># of fields:<br /><input class="input" size="3" type="text" name="rows"><input class="button" type="submit" value="Update" name="update_blanks"></td>
			</tr></form>
			</table></td>
		</tr>

		<form method="post" action="insert_category.php?<?=session_name()?>=<?=session_id()?>">
		<input type="hidden" name="RPID" value="<?=$RPID?>">
			
		<?
		
			if(isset($update_blanks)){
				$blanks = $rows;
			} else {
				$blanks = 10;
			}
			
			for($i=0; $i<$blanks; ++$i){

				$cell_color = "#dddddd";
				$i % 2  ? 0 : $cell_color = "#eeeeee";
				
				?>
				<tr bgcolor="<?=$cell_color?>">
					<td nowrap="nowrap"><span class="transtext">Category Name:</span></td>
					<td><input class="input" type="text" name="Category[]" size="25"></td>
				</tr>
				<tr bgcolor="<?=$cell_color?>">
					<td><span class="transtext">Description:<br /><br />Hint: If you want to hand pick your sub categories, create the nescessary html and enter it for the description.  Then pick "Desc" as your Children Categories Option below.</span></td>
					<td><textarea class="input" name="Description[]" rows="5" cols="30"></textarea></td>
				</tr>
				<tr bgcolor="<?=$cell_color?>">
					<td><span class="transtext">Children Categories Options:</span></td>
					<td><select class="small" name="Children[]">
						<option value="Top" selected>Categories with Most Sites 
						(Top)</option>
						<option value="Rand">Random Children Categories 
						(Rand)</option>
						<option value="Desc">Description of Category 
						(Desc)</option>
						<option value="Vert">List Children Categories Vertically 
						(Vert)</option>
					</select></td>
				</tr>
				<tr bgcolor="<?=$cell_color?>">
					<td><span class="transtext">Viewable Children Categories:</span></td>
					<td><input size="3" class="small" type="text" name="TopChildren[]" value="3" /></td>
				</tr>
				<? echo "<input type=\"hidden\" name=\"PID[]\" value=\"" . $PID . "\">"; ?>
				<tr bgcolor="<?=$cell_color?>">
					<td><span class="transtext">Allow Site submissions to this Category:</span></td>
					<td><select class="small" name="AllowSites[]"><?
						echo "<option value=\"Y\"";
						if(isset($PID) && $PID > 0){echo " selected";}
						echo ">Yes</option><option value=\"N\"";
						if(!isset($PID) || $PID == 0){echo " selected";}
						echo ">No</option>";
					?></select></td>
				</tr>
				<tr bgcolor="<?=$cell_color?>">
					<td><span class="transtext">Show Site Count for this Category:</span></td>
					<td><select class="small" name="ShowSiteCount[]"><?
							echo "<option value=\"Y\"";
							if(isset($PID) && $PID > 0){echo " selected";}
							echo ">Yes</option><option value=\"N\"";
							if(!isset($PID) || $PID == 0){echo " selected";}
							echo ">No</option>";
					?></select></td>
				</tr><?
			}
			?><tr bgcolor="<?=$cell_color?>">
				<td align="center" colspan="2">
				<input class="button" type="submit" value=" Add Categories " name="submit">
				<input class="button" type="reset" value=" Reset " name="reset"></td>
			</tr></form>
			<?
				}
			?>
			</table>
	</body>
</html>