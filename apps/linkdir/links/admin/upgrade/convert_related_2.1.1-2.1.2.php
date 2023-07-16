<?
// *******************************************************************
//  admin/upgrade/convert_related_2.1.1-2.1.2.php
// *******************************************************************

if(!isset($temp_related)){
	$temp_related = "temp_related";
}

include("../../include/config.php");
include("../../include/functions.php");

include("../../include/common.php");
$language = $gl["Language"];

include("../../include/lang/$language.php");

include("../../include/session.php");
// tcm remove php warning
// session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<title></title>
<link rel = "stylesheet" type = "text/css" href = "../style.css" />
</head>
<?=$adm_body?>
<?
if($submit){

	$create_sql = "create table " . $temp_related . " (id smallint (5) unsigned not null auto_increment, cat_id smallint (5) unsigned not null , rel_id smallint (5) unsigned not null , primary key (id))";

	if($create_query = sql_query($create_sql)){
		echo "<p>Table " . $temp_related . " created</p>";
	} else {
		$error = 1;
		$error_html = "Could not create table " . $temp_related . ".";
	}
	
	if(!isset($error)){
		
		echo "<p>Extracting old table data...</p>\n";
		
		$sql = "select * from $tb_related";
		$query = sql_query($sql);

		while($rows = sql_fetch_array($query)){
			
			for($x=1;$x<6;$x++){
				if($rows["R$x"] > 0){
					$cat_id[] = $rows["Category"];
					$rel_id[] = $rows["R$x"];
				}
			}
		}

		$z = sizeof($cat_id);

		echo "<p>Converting data:</p>\n";

		for($q=0;$q<$z;$q++){
			$insert_sql = "
				insert into $temp_related (
					id,
					cat_id,
					rel_id
				) values (
					'',
					'$cat_id[$q]',
					'$rel_id[$q]'
				)
			";
			if($rel_id[$q] > 0){
				if($insert_query = sql_query($insert_sql)){
					$t++;
					echo "<p>Relationship #" . $t . " converted.</p>\n";
				} else {
					$error = 1;
				}
				
			}
		}
		
		echo "<p>Data conversion complete.</p>\n";

	}

	echo "<p>I will now drop your old " . $tb_related . " table.</p>\n";

	$drop_sql = "drop table " . $tb_related;

	if($drop_query = sql_query($drop_sql)){
		echo "<p>Table " . $tb_related . " dropped.</p>";
	}

	echo "<p>I will now rename your new table " . $temp_related . ".</p>\n";

	$mv_sql = "alter table " . $temp_related . " rename as " . $tb_related;

	if($mv_query = sql_query($mv_sql)){
		echo "<p>Table " . $temp_related . " renamed as " . $tb_related . ".</p>\n";
	}

	if(!isset($error)){
		echo "<p>I am finished... ;)</p>\n";
	} else {
		echo "<p>Oh No! :(</p>\n";
	}
	
} else {
	
	$sql = "select * from $tb_related";
	$query = sql_query($sql);

	while($rows = sql_fetch_array($query)){
		
		for($x=1;$x<6;$x++){
			if($rows["R$x"] > 0){
				$rel_id[] = $rows["R$x"];
			}
		}
	}

	$count = sizeof($rel_id);
}

if(isset($submit) && !isset($error)){
	?>
	<p>A total of <?=$t?> Unique Category Relationships were converted.</p>
	<p>Please delete this script now : <b><?=$SCRIPT_NAME?></b>.</p>
	<?
}

if(isset($error)){
	?>
	<p>I encountered an error:</p>
	<p><?=$error_html?></p>
	<p>Please make sure your mysql connection information is correct in config.php, and that the user is allowed to create and drop tables.</p>
	<?
}

if(!isset($error) && !isset($submit)){
	?>
	
	<p class="title">Convert Related Categories - 2.1.1 -> 2.1.2</p>
	
	<p>Hello, I am a php script named convert_related_2.1.1-2.1.2.php.  I will convert your current <b><?=$count?></b> Related Categories table into a much more efficient format.  It seems destiney wasn't as informed on sql table relationships as he should have been when he first began the phpLinks project long ago.  I will fix his mistakes by converting your related table to a new structure ;)</p>

	<p>I have to use a temporary table in your database to do the conversion.  I plan to create a table named <b><?=$temp_related?></b>.  If this is ok with you please proceed, if not please change the name in the form below.</p>

	<p><form method="post" action="<?=$SCRIPT_NAME?>">
	<input type="text" name="temp_related" value="<?=$temp_related?>" /><input type="submit" name="submit" value=" Do It -> " />
	</form></p>
	<?
}

?><br /><br />
</body>
</html>