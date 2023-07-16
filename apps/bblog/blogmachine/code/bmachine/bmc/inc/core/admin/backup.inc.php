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

// Do the backup
if(isset($_POST['action']) && $_POST['action'] == "do_backup") {
	include CFG_ROOT."/inc/core/admin/mysql_bkp.php";
	exit;
}

// Delete a backup
if(isset($_GET['delete']) && !strpos("-".$_GET['delete'], "/") && !strpos("-".$_GET['delete'], "\\")) {

		$file=str_replace("\\","",$_GET['delete']);
		$file=str_replace("/","",$file);
		$file=str_replace("..","",$file); // Remove .. and / for security

	@unlink(CFG_PARENT."/backup/".$file);
	bmc_Go($bmc_vars['c_urls']."/".BMC_DIR."/admin.php?action=backup#prev");
}


// Restore data
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "restore") {

	// Restore an uploaded file
	if(isset($_FILES['file']['name'])) {

		$userfile_name = $_FILES['file']['name'];
		$userfile_tmp = $_FILES['file']['tmp_name'];

		// Get the file extension
		$ext=explode(".",$userfile_name);
		$ext=trim($ext[count($ext)-1]);

		// Create temporary file
		$file_temp=md5($userfile_name);

		move_uploaded_file($userfile_tmp, CFG_PARENT."/backup/$file_temp") or bmc_template('error_admin', $lang['admin_restore_fail']);

		// Open the file, read the data
		if($ext == "gz") {
			// Read gzipped data
			$zd = gzopen(CFG_PARENT."/backup/$file_temp", "r");
			$queries = gzread($zd, filesize(CFG_PARENT."/backup/$file_temp"));
			gzclose($zd);
		} else {
			// Read plain text data
			$queries=@fread(fopen(CFG_PARENT."/backup/$file_temp", "r"), filesize(CFG_PARENT."/backup/$file_temp"));
		}
	} else {
		if(isset($_GET['file'])) {
			$file=str_replace("\\","",$_GET['file']);
			$file=str_replace("/","",$file);
			$file=str_replace("..","",$file); // Remove .. and / for security

			$queries=@fread(fopen(CFG_PARENT."/backup/$file", "r"), filesize(CFG_PARENT."/backup/$file")) or bmc_Template('error_admin',$lang['admin_restore_fail']);
		} else {
			bmc_Template('error_admin',$lang['admin_restore_fail']);
		}
	}


	$queries=explode("\n", $queries);

	for($i=0;$i<count($queries);$i++) {
		$queries[$i]=trim($queries[$i]);

		if($queries[$i][0] != "#") { // Ignore comments
			$new_queries[]=$queries[$i];
		}
	}

   $qr=explode(";\n",implode("\n",$new_queries));

	// Carry out the queries
	foreach($qr as $qry) {
		if(trim($qry)) @$db->query($qry);
	}

	// Delete the temp file
	@unlink(CFG_PARENT."/backup/$file_temp");

	// =========== Now its time to sync the blog with the updated database records

	// Update the XML feeds
	$result=null; $i_blog=null;
	$result=$db->query("SELECT id,m_rss,blog_file,blog_name FROM ".MY_PRF."blogs WHERE frozen='0' and m_rss='1'");

	$bmc_path=BMC_DIR;

	foreach($result as $i_blog) {

		include CFG_ROOT."/inc/core/rss.build.php";

		// Also create the static files if possible

		if(!empty($i_blog['blog_file']) && !file_exists(CFG_PARENT."/".$i_blog['blog_file'])) {
			clearstatcache();

$blog_data=<<<EOF
<?php
	// Static loader for blog '{$i_blog['blog_name']}' on {$date}
	\$blog_id={$i_blog['id']};
	include dirname(__FILE__)."/{$bmc_path}/start.php";
?>
EOF;
	
			$fp=fopen(CFG_PARENT."/".$i_blog['blog_file'], "w+");
			fputs($fp, $blog_data);
			fclose($fp);
		}

	}

	// Update the blog list/category list/ and the archive list
	bmc_updateCache('blogs');
	bmc_updateCache('cats');
	bmc_updateCache('archive');


	bmc_Template('admin_header',$lang['admin_restore_ok']);
	echo "<strong>".$lang['admin_restore_ok']."</strong>";
	bmc_Template('admin_footer');
	exit;
}


// ====================== The backup page

bmc_Template('admin_header', $lang['admin_backup_title']);
?>
<p><strong><?php echo $lang['admin_backup_title']; ?></strong></p>
<p><?php echo $lang['admin_backup_note']; ?></p>
<form name="backup" method="POST" action="admin.php">
<input type="hidden" name="action" value="do_backup" />
<input type="submit" value="<?php echo $lang['admin_backup_but']; ?>" /><br />
<input type="checkbox" name="bk_gzip" value="true" /> <?php echo $lang['admin_backup_gzip']; ?><br /><br />

<input type="checkbox" name="bkp_posts" value="true" checked /> <?php echo $lang['total_articles']; ?><br />
<input type="checkbox" name="bkp_comments" value="true" checked /> <?php echo $lang['comments']; ?><br />
<input type="checkbox" name="bkp_blogs" value="true" checked /> <?php echo $lang['blogs']; ?><br />
<input type="checkbox" name="bkp_cats" value="true" checked /> <?php echo $lang['cats']; ?><br />
<input type="checkbox" name="bkp_settings" value="true" checked /> <?php echo $lang['admin_set']; ?><br />
<input type="checkbox" name="bkp_users" value="true" checked /> <?php echo $lang['users']; ?><br />
<input type="checkbox" name="bkp_votes" value="true" checked /> <?php echo $lang['votes']; ?><br />
<input type="checkbox" name="bmp_trackbacks" value="true" checked /> <?php echo $lang['trackbacks']; ?><br />
</form>

<br />
<hr width="100%" size="1" color="#CCCCCC">
<p><strong><?php echo $lang['admin_backup_restore']; ?></strong></p>

<script type="text/javascript">
<!--

function warnRestore(file) {
var msg=confirm('<?php echo $lang['admin_restore_warn']; ?>');

	if(!msg) {
		return;
	} else {
		document.location="?action=restore&file="+file;
	}

}

//-->
</script>

<form name="restore" method="POST" action="admin.php" ENCTYPE="multipart/form-data">
<input type="hidden" name="action" value="restore" />
<?php echo $lang['admin_restore_title']; ?><br />
<?php echo $lang['admin_restore_warn']; ?>
<br /><input type="file" name="file" maxlength="60" size="46"> 
<br />
<input type="submit" value="<?php echo $lang['admin_restore_but']; ?>"></form>
<br />
<hr width="100%" size="1" color="#CCCCCC">
<span id="prev"></span>
<strong><?php echo $lang['admin_backup_previous']; ?></strong><br /><br />
<table border="0" cellpadding="5" cellspacing="0" width="100%">

<?php

// List the existing backup files

	$handle = opendir(CFG_PARENT."/backup");
	while($file = readdir($handle)) {
	$ext=explode(".", $file);
	$ext=$ext[count($ext)-1];
		if( $ext == "gz" || $ext == "sql" ) {
?>

<tr>
<td width="50%">
<p><a href="<?php echo $bmc_vars['c_urls']; ?>/backup/<?php echo $file; ?>"><?php echo $file; ?></a></p>
</td>

<td width="25%">
<p>( <a href="javascript:warnRestore('<?php echo $file; ?>');" title="<?php echo $lang['admin_backup_restore']; ?>"><?php echo $lang['admin_backup_restore']; ?></a> )</p>
</td>

<td width="25%">
<p><a href="?action=backup&delete=<?php echo $file; ?>"><?php echo $lang['admin_backup_delete']; ?></a></p>
</td>
</tr>
<?php
		}
	}

echo "</table><br /><br />";

bmc_Template('admin_footer');
exit;

?>