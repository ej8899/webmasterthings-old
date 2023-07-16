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


// ====================
// Create a new blog

	if($_POST['action'] == "create_blog") {

		if($db->row_count("SELECT * FROM ".MY_PRF."blogs where blog_name='".trim($_POST['blog_name'])."'")) {
			bmc_template('error_admin', $lang['error'],$lang['admin_blog_new_err']);
		}


		if(empty($_POST['static_file'])) {
			$file=$_POST['blog_name'];
		}
		else {
			$file=$_POST['static_file'];
		}
		$file=str_replace(" ","_", $file).".php"; // The static file for the blog

		// The static file already exists
		if(file_exists(CFG_PARENT."/$file")) {
			bmc_template('error_admin', $lang['admin_blog_new_file_no']);
		}

		$time=time();
		$db->query("INSERT INTO ".MY_PRF."blogs (blog_name, blog_date, blog_file) VALUES('".trim($_POST['blog_name'])."','$time', '$file')");
		$the_id=$db->query("SELECT id FROM ".MY_PRF."blogs WHERE blog_name='{$_POST['blog_name']}'", false);
		$the_id=$the_id['id'];
		$date=bmcDate($time);




// Write static php script for the new blog
$blog_data=<<<EOF
<?php
	// Static loader for blog '{$_POST['blog_name']}' on {$date}
	\$blog_id={$the_id};
	include dirname(__FILE__)."/{$bmc_path}/start.php";
?>
EOF;
	
		$fp=fopen(CFG_PARENT."/$file", "w+");
		fputs($fp, $blog_data);
		fclose($fp);

		bmc_updateCache('blogs'); // Update the cache

		bmc_Go("?null");
	}


	// ======================================= Delete a blog

	if($_GET['action']=="del_blog") {

		// Show the warning
		if($_GET['step']=="1") {
		bmc_Template('admin_header', "Warning! :: Delete blog");

echo <<<EOF

<br /><br />
<div class="hold_center">
<h1>{$lang['admin_blog_del_title']}</h1>

{$lang['admin_blog_del_msg']}<br /><br />

<div>
<form method="post" action="{$_SERVER['PHP_SELF']}?blog={$_GET['blog']}&action=del_blog">
<input type="button" onClick="javascript:history.go(-1)" value="  {$lang['back']}  " />&nbsp;&nbsp;
<input type="submit" value="{$lang['admin_blog_del']}" />
</form>
</div>

</div>
EOF;
		bmc_Template('admin_footer');
		exit;
		}


	// Delete the blog and all related entities
	$db->query("DELETE FROM ".MY_PRF."blogs WHERE id='".BLOG."'");
	$db->query("DELETE FROM ".MY_PRF."posts WHERE blog='".BLOG."'");
	$db->query("DELETE FROM ".MY_PRF."cats WHERE blog='".BLOG."'");
	$db->query("DELETE FROM ".MY_PRF."blogs WHERE id='".BLOG."'");

	// Kill the existing static file
	@unlink(CFG_PARENT."/".$i_blog['blog_file']);

	bmc_updateCache('blogs'); // Update the cache
	bmc_Go("?null");

	}

// ====================
// Posts management

if(isset($_REQUEST['action'])) {

	switch($_REQUEST['action']) {

		// List the posts
		case 'list_posts';
		case 'delete_posts': // Delete
		include CFG_ROOT."/inc/core/admin/posts.inc.php";
		exit;

		// Save a new post
		case 'save_post':
		include CFG_ROOT."/inc/users/post.inc.php";
		exit;

		// Modify a post
		case 'mod_post':
		include CFG_ROOT."/inc/users/edit.inc.php";
		exit;

		// Edit post page
		case 'edit_post':
		bmc_Template('admin_header', $lang['post_edit_title']);
		include CFG_ROOT."/inc/users/edit_form.php";
		bmc_Template('admin_footer');
		exit;

		// New post
		case 'new_post':
		bmc_Template('admin_header', $lang['user_new_title']);
		include CFG_ROOT."/inc/users/post_form.php";
		bmc_Template('admin_footer');
		exit();

		// Edit comments
		case 'edit_comments':
		case 'mod_comment':
		include CFG_ROOT."/inc/core/admin/comments.inc.php";
		exit;

		// Delete comments
		case 'delete_comment':
		include CFG_ROOT."/inc/core/admin/comments.inc.php";
		exit;

		// Categories
		case 'cats':
		include CFG_ROOT."/inc/core/admin/cats.inc.php";
		exit;

	}
}


?>