<?php

/*
  ===========================

  boastMachine v3.0 Platinum
  Released : Sunday, October 17th 2004 ( 10/17/2004 )
  http://boastology.com

  Developed by Kailash Nadh
  Email   : kailash@bnsoft.net
  Website : www.kailashnadh.name
			www.bnsoft.net

  boastMachine is a free software and is licensed under GPL (General public license)

  ===========================
*/

	if(!defined('IN_BMC')) {
		die("Access Denied!");
	}


// If the form was posted, carry out the deletion.
if(isset($_POST['action']) && $_POST['action'] == "file_manager" && isset($_POST['files'])) {
	for($n=0;$n<count($_POST['files']);$n++) {

		$file=str_replace("\\","",$_POST['files'][$n]);
		$file=str_replace("/","",$file);
		$file=str_replace("..","",$file); // Remove . and / for security

		@unlink(CFG_PARENT."/files/".$file);
	}

	bmc_Go("?action=file_manager");
}


bmc_Template('admin_header', $lang['admin_file']);

echo "<h1>".$lang['admin_file']."</h1>";
?>

<form name="files" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="action" value="file_manager" />
<select name="files[]" multiple size="15">

<?php

	$file_list=array();

		// Collect the file list
		$handle = opendir(CFG_PARENT."/files");
			while($file_name = readdir($handle)) {
				if($file_name != "." && $file_name != "..") {
					$file_list[]=$file_name;
				}
			}
		closedir($handle);

		sort($file_list);

	// Print the list
	for($n=0;$n<count($file_list);$n++) {
		echo "<option value=\"{$file_list[$n]}\">{$file_list[$n]}</option>\n";
	}

?>


</select><br /><br />
<input type="button" onClick="javascript:delFile();" value="<?php echo $lang['file_but_del']; ?>" />
</form>

<script type="text/javascript">
<!--

	function delFile() {
		var msg=confirm("<?php echo $lang['file_del_msg']; ?>");

		if(msg) {
			document.files.submit();
		}

	}
//-->
</script>

<?php
	bmc_Template('admin_footer');
?>