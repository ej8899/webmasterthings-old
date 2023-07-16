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

include_once dirname(__FILE__)."/main.php";

// ============================ USER CONFIGURATION ==================================

$max_size="500"; //KB
	// Maximum permitted file upload size IN KILO BYTES (KB)

$ok_exts="jpg,jpeg,zip,gif,png,html,htm,txt,gz,rar,doc,pdf";
	// Permitted file extensions . Each separated by a comma. No spaces please

// ==================================================================================



// Check whether the user is logged in
$user=bmc_isLogged();

// Its not a valid user, so close the window
if(!$user || !$bmc_vars['m_files']) {
echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>{$lang['admin_file_no']}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
<!--
body, html {
	font-family: Verdana;
	font-size: 10px;
	color: #333333;
}

input,select {
	font-family: Verdana;
	font-size: 10px;
	background: #F6F6F6;
}



//-->
</style>

</head>

<body>

<h4>{$lang['admin_file_no']}</h4>



</body>
</body>

EOF;
exit;
}

// The edit form? or the post form ?
if(isset($_POST['form_id']) && $_POST['form_id']=="edit") {
	$form="modpost";
} else {
	$form="newpost";
}

// Delete a file?
if(isset($_POST['delete_files']) && $_POST['delete_files'] == "true") {

	// No files selected.
	if(!isset($_POST['files']) || !$_POST['files']) {
		bmc_Go("files.php?form_id=".$form); exit;
	}

	for($n=0;$n<count($_POST['files']);$n++) {
		$file=str_replace("\\","",$_POST['files'][$n]);
		$file=str_replace("/","",$file);
		$file=str_replace("..","",$file); // Remove . and / for security
		$file_spec=explode("_", $file);

		// Check whether that attached file is this person's itself
		if($file_spec[0] == $user) {
			@unlink(CFG_PARENT."/files/".$file); // Delete
		}

	}
		bmc_Go("files.php?form_id=".$form); exit;
}

// File uploading is not permitted
if(!$bmc_vars['m_files']) {
	bmc_template('error_page', $lang['file_no']); exit;
}

	// Upload the files
if(isset($_POST['action']) && $_POST['action'] == "upload_files" || $_POST['action'] == "attach_files") {
	include CFG_ROOT."/inc/users/files.inc.php";
	exit;
}

// Is it the edit form?
if(isset($_GET['form']) && $_GET['form']=="edit") {
	$form="edit";
} else {
	$form="new";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php echo $lang['file_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
<!--
body, html {
	font-family: Verdana;
	font-size: 10px;
	color: #333333;
}

input,select {
	font-family: Verdana;
	font-size: 10px;
	background: #F6F6F6;
}



//-->
</style>

</head>

<body>
<div>
<form name="files" method="post" action="<?php echo $_SERVER['php_self']; ?>" ENCTYPE="multipart/form-data">
<input type="hidden" name="action" value="upload_files" />
<strong><?php echo $lang['file_title']; ?></strong><br /><br />
<?php echo $lang['file_fl']; ?>#1 : <input type="file" name="file1" /><br />
<?php echo $lang['file_fl']; ?>#2 : <input type="file" name="file2" /><br />
<?php echo $lang['file_fl']; ?>#3 : <input type="file" name="file3" /><br />
<?php echo $lang['file_fl']; ?>#4 : <input type="file" name="file4" /><br />
<?php echo $lang['file_fl']; ?>#5 : <input type="file" name="file5" /><br />
<br /><br /><input type="submit" value="<?php echo $lang['file_but']; ?>" />
</form>
<br /><br />

<strong><?php echo $lang['post_attach']; ?></strong><br /><br />
<form name="attach" method="post" action="<?php echo $_SERVER['php_self']; ?>" ENCTYPE="multipart/form-data">
<input type="hidden" name="action" value="attach_files" />
<input type="hidden" name="delete_files" value="false" />
<input type="hidden" name="form_id" value="<?php echo $form; ?>" />
<select name="files[]" size="10" multiple="true">
<?php

// Read the file upload list from the file storage

	$handle = opendir(CFG_PARENT."/files");
	$i=0; $j=0;

while($filename = readdir($handle)) 
{
	if($filename != "." && $filename != ".." && trim($filename)) { 
		$file_spec=explode("_", $filename);
		if($file_spec[0] == $user) {
			echo "<option value=\"{$filename}\">{$filename}</option>";
		}
	}
}
	closedir($handle);

?>
</select><br /><br />
<input type="button" onClick="javascript:goAttach();" value="<?php echo $lang['file_add_but']; ?>" />  
<input type="button" onClick="javascript:goDel();" value="<?php echo $lang['file_but_del']; ?>" /></form>

<br /><br />
<a href="javascript:window.close();"><?php echo $lang['close']; ?></a>

<script type="text/javascript">
<!--
	function goDel() {
		var msg=confirm("<?php echo $lang['file_del_msg']; ?>");

		if(msg) {
			document.attach.delete_files.value="true";
			document.attach.submit();
		}
	}

	function goAttach() {
			document.attach.delete_files.value="false";
			document.attach.submit();
	}

//-->
</script>

</div>
</body>
</html>