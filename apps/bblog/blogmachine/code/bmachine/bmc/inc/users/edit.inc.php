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

// Invalid call
if(!isset($_REQUEST['action'])) {
	bmc_Go($bmc_vars['c_urls']); exit;
}


// Empty fields
if(!isset($_POST['title']) || empty($_POST['title']) || empty($_POST['smr']) || !isset($_POST['smr'])) {
	bmc_template('error_page', $lang['empty_fields'],$lang['empty_fields']);
	exit();
}

if(!isset($_POST['cat']) || !isset($_POST['format'])) {
	bmc_template('error_page', $lang['empty_fields'],$lang['empty_fields']);
	exit();
}

if(isset($_POST['password']) && !empty($_POST['password']) && strlen($_POST['password']) < 5) {
	bmc_template('error_page', $lang['user_short_pass'],$lang['user_short_pass']);
	exit;
}


// Get some data of the post being edditted. Used for some validation purposes
$i_post=$db->query("SELECT id,date,author,blog FROM ".MY_PRF."posts WHERE id='{$_POST['id']}' AND author='{$_POST['author']}'", false);
if(!$i_post) {
	bmc_Go($bmc_vars['c_urls']); exit;
}

// Do some validations
if(isset($_POST['id']) && is_numeric($_POST['id'])) {
	if($i_post['id'] != $_POST['id']) {
	bmc_template('error_page', $lang['post_no_mod']);
	}
} else {
	bmc_template('error_page', $lang['post_no_mod']);
}

if(isset($_POST['author']) && is_numeric($_POST['author'])) {
	if($i_post['author'] != $_POST['author']) {
	bmc_template('error_page', $lang['post_no_mod']);
	}
} else {
	bmc_template('error_page', $lang['post_no_mod']);
}


// Setting up the data variables..

// ======= Check whether the user has entered anything in the post body field
if(!isset($_POST['msg']) || empty($_POST['msg'])) {
	$data="";
} else {
	$data=$_POST['msg'];
}


// ======= Verify the post date
if(isset($_POST['date']) && md5($_POST['date']) != md5(date("m/d/Y h:i:s a",$i_post['date']))) {
	$date=strtotime($_POST['date']);
} else {
	$date=$i_post['date'];
}

if($date == "-1") {
	$date=$i_post['date'];
}


// Password for the current post, if any
if(isset($_POST['password']) && !empty($_POST['password']) && strlen($_POST['password']) > 5) {
	$password=$_POST['password'];
} else {
	$password="";
}

// Keywords if any
if(isset($_POST['keywords']) && !empty($_POST['keywords'])) {
	$keywords=$_POST['keywords'];
} else {
	$keywords="";
}


// ======= Get the post format
if(isset($_POST['format']) && !empty($_POST['format']) && $bmc_vars['m_html']) {
	switch ($_POST['format']) {
		case 'text':
		$format="text";
		break;

		case 'html':
		$format="html";
		break;

		default:
		$format="text";
		break;
	}
} else {
	$format="text";
}

// ======= Decide the post status
if(isset($_POST['status']) && !empty($_POST['status'])) {

	switch($_POST['status']) {
		case 'draft':
		$status="2";
		$draft_date=mktime(1,1,1,$_POST['draft_month'],$_POST['draft_day'],$_POST['draft_year']); // Being a draft, set its appearance date
		break;

		case 'hidden':
		$status="0";
		break;

		default:
		$status="1";
		break;
	}
}

// ======= Is Commenting enabled for thist post?
if(isset($_POST['m_cmt'])) {
	$m_cmt=1;
} else {
	$m_cmt=0;
}

// ======= Is Voting enabled for this post?
if(isset($_POST['m_vote'])) {
	$m_vote=1;
} else {
	$m_vote=0;
}

// ======= Is AutoBr enabled for this post?
if(isset($_POST['m_autobr'])) {
	$m_autobr=1;
} else {
	$m_autobr=0;
}

// ======= Accept trackbakcs?
if(isset($_POST['m_trackback'])) {
	$m_trackback=1;
} else {
	$m_trackback=0;
}

// ======= The blog to which this post belongs
if(defined('BLOG') && BLOG != "") {
	$blog=BLOG;
} else {
	// There's some serious problem! The constant 'BLOG' is empty!
	bmc_template('error_page', $lang['post_no_blog']); exit;
}

// ======= The target category
if(isset($_POST['cat'])) {
	// Something wrong. The selected category couldnt be found in the current blog
	if(!$db->query("SELECT id FROM ".MY_PRF."cats WHERE id='{$_POST['cat']}' AND blog='{$blog}'", false)) {
	bmc_template('error_page', $lang['post_no_cat']); exit;
	}

} else {
	// No category!
	bmc_template('error_page', $lang['post_no_cat']); exit;
}

// ======= File attachments :)
if(isset($_POST['files']) && !empty($_POST['files'])) {

	$files=explode("|",$_POST['files']); // Create an array of the posted filenames

	for($n=0;$n<count($files);$n++) {
		if(!empty($files[$n])) {

			$file_specs=explode("_",$files[$n]);

			if($file_specs[0] == $user) {
				$file_name=implode("_",$file_specs);
				$file_list.=$file_name."|";
			}
		}
	}
}


// ======= Enter the data into the table
$db->query("UPDATE ".MY_PRF."posts SET title='{$_POST['title']}', cat='{$_POST['cat']}', summary='{$_POST['smr']}', data='{$data}', keyws='{$keywords}', file='{$file_list}', format='{$format}', date='{$date}', draft_date='{$draft_date}', password='{$password}', status='{$status}', m_cmt='{$m_cmt}', m_vote='{$m_vote}', m_autobr='{$m_autobr}', m_trackback='{$m_trackback}' WHERE blog='{$blog}' AND author='{$i_post['author']}' AND id='{$i_post['id']}'");

	bmc_updateCache('archive'); // Update the archive cache

	// Generate the RSS feeds if set
	if($bmc_vars['m_rss']) {
		include CFG_ROOT."/inc/core/rss.build.php";
	}

	if(defined('IN_ADMIN')) {
		bmc_Go("Location: {$bmc_vars['c_urls']}/".BMC_DIR."/admin.php?blog={$blog}&action=list_posts"); // The admin
	} else {
		bmc_Go("Location: {$bmc_vars['c_urls']}/user.php"); // The user
	}

?>