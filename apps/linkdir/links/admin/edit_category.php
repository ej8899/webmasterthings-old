<?
// *******************************************************************
//  admin/edit_category.php
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
<title></title>
<link rel = "stylesheet" type = "text/css" href = "style.css" />
</head>
<?=$adm_body?><?

if(isset($submit)){

	if(isset($Category)){$Category = eregi_replace(" ", "_", $Category);}

		$update = sql_query("
			update
				$tb_categories
			set
				Category				=	'$Category',
				Description			=	'$Description',
				Children				=	'$Children',
				TopChildren			=	'$TopChildren',
				AllowSites			=	'$AllowSites',
				ShowSiteCount		=	'$ShowSiteCount'
			where
				ID='$ID'
		");
	}

	if(isset($ID)){							
		
		$get_category = sql_query("select * from $tb_categories where ID='$ID'");
		$get_row = sql_fetch_array($get_category);

	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
		<form method="post" action="edit_category.php?<?=session_name()?>=<?=session_id()?>">
		<tr>
			<td colspan="2" align="center" nowrap="nowrap" class="theader">Edit Category <?=eregi_replace("_", " ", $get_row[Category])?><? if(isset($submit)){ ?> - Category has been updated<?}?></td>
		</tr>
		<tr bgcolor="<?=$cell_color?>">
			<td nowrap="nowrap" class="text"> Category Name: </td>
			<td>
				<input class="small" type="text" name="Category" size="25" value="<?
				echo eregi_replace("_", " ", $get_row[Category]);
				?>"></td>
		</tr>
		<tr bgcolor="<?=$cell_color?>">
			<td class="text">Description:<br /><br />Hint: If you want to hand pick your sub categories, create the nescessary html and enter it for the description.  Then pick "Desc" as your Children Categories Option below.</td>
			<td><textarea class="small" name="Description" rows="5" cols="30"><?=$get_row[Description]?></textarea></td>
		</tr>
		<tr bgcolor="<?=$cell_color?>">
			<td class="text">Children Categories Options:</td>
			<td><select class="small" name="Children"><?
			echo "<option value=\"Top\"";
			if($get_row[Children] == "Top"){echo " selected";}
			echo ">Categories with Most Sites (Top)</option><option value=\"Rand\"";
			if($get_row[Children] == "Rand"){echo " selected";}
			echo ">Random Children Categories (Rand)</option><option value=\"Desc\"";
			if($get_row[Children] == "Desc"){echo " selected";}
			echo ">Description of Category (Desc)</option><option value=\"Vert\"";
			if($get_row[Children] == "Vert"){echo " selected";} 
			echo ">List Children Categories Vertically (Vert)</option>"; 
			?></select></td>
		</tr>
		<tr bgcolor="<?=$cell_color?>">
			<td class="text">Viewable Children Categories:</td>
			<td><input size="3" class="small" type="text" name="TopChildren" value="<?=$get_row[TopChildren]?>" /></td>
		</tr>
		<input type="hidden" name="ID" value="<?=$ID?>">
		<tr bgcolor="<?=$cell_color?>">
			<td class="text">Allow Sites to populate this Category:</td>
			<td><select class="small" name="AllowSites"><?
				echo "<option value=\"Y\"";
				if($get_row["AllowSites"] == "Y"){echo " selected";}
				echo ">Yes</option><option value=\"N\"";
				if($get_row["AllowSites"] == "N"){echo " selected";}
				echo ">No</option>";
			?></select></td>
		</tr>
		<tr bgcolor="<?=$cell_color?>">
			<td class="text">Show Site Count for this Category:</td>
			<td><select class="small" name="ShowSiteCount"><?
				echo "<option value=\"Y\"";
				if($get_row["ShowSiteCount"] == "Y"){echo " selected";}
				echo ">Yes</option><option value=\"N\"";
				if($get_row["ShowSiteCount"] == "N"){echo " selected";}
				echo ">No</option>";
			?></select></td>
		</tr>
		<tr bgcolor="<?=$cell_color?>">
			<td align="center" colspan="2">
			<input class="button" type="submit" value=" Update Category " name="submit">
			</td>
		</tr></form><?
		
		if(isset($submit)){
			?>
				<tr>
					<td class="text" align="center" colspan="2"><a 
					href="categories_main.php?<?=session_name()?>=<?=session_id()?>">Click here to edit other categories.</a></td>
				</tr><?
		} ?></table><?

	} else {
	
	?><table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
	<tr><form method="post" action="edit_category.php?<?=session_name()?>=<?=session_id()?>">
		<td class="theader" align="center">Enter Category ID: <input class="small" type="text" name="ID" size="3">
		</td>
	</tr>
	<tr>
		<td align="center">
			<input class="button" type="submit" value=" Edit Category " 
			name="edit_category">
		</td>
	</tr></form>
	</table><?
	}
?></body>
</html>
