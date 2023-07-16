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


if($_POST['action'] == "attach_files") {

// The edit form? or the post form ?
if(isset($_POST['form_id']) && $_POST['form_id']=="edit") {
	$form="modpost";
} else {
	$form="newpost";
}

?>
<HTML>
<HEAD>
<TITLE>Closing..</TITLE>
</HEAD>
<BODY>
<script type="text/javascript">
<!--

window.opener.document.getElementById('file_div').innerHTML="";
window.opener.document.<?php echo $form; ?>.files.value="";

<?php
	for($n=0;$n<count($_POST['files']);$n++) {
	echo "window.opener.document.getElementById('file_div').innerHTML=window.opener.document.getElementById('file_div').innerHTML+\"<a href=\\\"{$bmc_vars['c_urls']}/files/{$_POST['files'][$n]}\\\" target=\\\"_blank\\\">{$_POST['files'][$n]}</a>, \"\n";
	echo "window.opener.document.{$form}.files.value=window.opener.document.{$form}.files.value+\"|{$_POST['files'][$n]}\"\n";
	}
?>

window.close();

//-->
</script>
</BODY>
</HTML>
<?php
exit;
}



// Upload the files

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
}

input {
	font-family: Verdana;
	font-size: 10px;
}
//-->
</style>

</head>

<body>
<div>
<?php

//===== Upload the files

for($n=1;$n<=count($_FILES);$n++) {
	$str="file".$n;
	$file=$_FILES[$str];
	$file_ok=false;
	$ok=false;

	if(!empty($file['name']) && !empty($file['tmp_name'])) {
	$file_ok=true;

			// Check or valid filesize
			if(!isset($file['size']) || $file['size'] > ($max_size*1024) && $file_ok) {
				echo "<strong>".$file['name']."</strong><br />".str_replace("%num%",$n,$lang['file_fail_size'])."<br />";
				$file_ok=false;
			}

			// Check whether the file has a valid extension
			$ext=explode(".",$file['name']);
			$ext=trim($ext[count($ext)-1]);

			// no extension
			if(!isset($ext) && $file_ok) {
				echo "<strong>".$file['name']."</strong><br />".str_replace("%num%",$n,$lang['file_fail_ext'])."<br /><br />";
				$file_ok=false;
			}

			if($file_ok) {
				$file_ok=false; // Set the flag to false

				$exts=explode(",",$ok_exts);
				for($i=0;$i<count($exts);$i++) {
					// If any one extension from the list matches the current file's extension, then set the flag to true
					// and break out from the loop
					if(isset($exts[$i]) && trim($exts[$i])) {
						if(trim($exts[$i]) == $ext) {
							$file_ok=true; break;
						}
					}
				}

				if(!$file_ok) {
					echo "<strong>".$file['name']."</strong><br />".str_replace("%num%",$n,$lang['file_fail_ext'])."<br /><br />";
				}
			}

			// Upload the file if everything was ok
			if($file_ok) {
				if(!@move_uploaded_file($_FILES[$str]['tmp_name'], CFG_PARENT."/files/".$user."_".$_FILES[$str]['name'])) {
					echo "<strong>".$file['name']."</strong><br />".str_replace("%num%",$n,$lang['file_fail'])."<br /><br />";
					$file_ok=false;
				}
			}

	if($file_ok) {
		echo "<strong>".$file['name']."</strong><br />".str_replace("%num%", $n, $lang['file_done'])."<br /><br />";
	}

	}


}


?>
<br /><br /><br />
<a href="<?php echo $bmc_vars['c_urls']."/bmc/files.php?form={$_POST['form_id']}"; ?>"><?php echo $lang['back']; ?></a>&nbsp;&nbsp;&nbsp;<a href="javascript:window.close();"><?php echo $lang['close']; ?></a>
</div>
</body>
</html>