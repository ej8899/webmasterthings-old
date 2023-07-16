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


	include_once dirname(__FILE__)."/config.php";
	include_once dirname(__FILE__)."/$bmc_dir/main.php";


	if(!isset($_REQUEST['id']) || !is_numeric(trim($_REQUEST['id']))) {
		bmc_Go($bmc_vars['c_urls']);
	}

	if(isset($_REQUEST['blog']) && is_numeric($_REQUEST['blog'])) {
		$i_post=$db->query("SELECT id,m_cmt FROM ".MY_PRF."posts WHERE blog='{$_REQUEST['blog']}' AND id='{$_REQUEST['id']}' AND status='1'", false);

		if(!$i_blog['blog_name']) {
			bmc_template('error_page', $lang['no_blog']);
		}

		if(!$i_post['id']) {
			bmc_template('error_page', $lang['no_id']);
		}

		// Check whether commenting is enabled
		if(!$bmc_vars['m_cmt']) {
			bmc_template('error_page', $lang['cmt_no_comment']);
		}

		// Commenting is not enabled
		if(!$i_post['m_cmt']) {
			bmc_template('error_page', $lang['cmt_no_comment_post']);
		}

	} else {
			bmc_template('error_page', $lang['no_blog']);
	}


	$user=bmc_isLogged(); // The currently logged in user

	// Check whether guests can comment
	if(!$bmc_vars['m_cmt_guests'] && !$user) {
		bmc_template('error_page', $lang['cmt_guest_no']);
	}

	// Show the comment form
	if(!isset($_POST['action']) || $_POST['action'] != "post_comment") {
		bmc_Template('page_header', $lang['cmt_post_ttl']);
		include CFG_PARENT."/templates/".CFG_THEME."/comment.form.php";
		bmc_Template('page_footer');
		exit;
	}


// =============== Save the comment

if(isset($_POST['action']) && $_POST['action'] == "post_comment" && isset($_POST['id']) && is_numeric($_POST['id'])) {

	// Check whether the user is posting more than 1 comment/session
	if($bmc_vars['m_cmt_ses']) {
		if(isset($_COOKIE['bmc_cmt_sess'])) {
			$commented=unserialize($_COOKIE['bmc_cmt_sess']); // Get the list of posts on which the user has voted

			if(isset($commented[$_REQUEST['id']])) {
				bmc_template('error_page', $lang['error'],$lang['del_cmt_sess']);
			}

		}
	}

	// Check for empty fields
	if(empty($user)) {

		if(empty($_POST['name'])) {
			bmc_template('error_page', $lang['empty_fields']);
		}

		if(empty($_POST['email'])) {
			$email="";
		} else {
			$email=$_POST['email'];
		}

		if(empty($_POST['url'])) {
			$url="";
		} else {
			$url=$_POST['url'];
		}

	} else {
		// Get the user's ID
		$user_id=$db->query("SELECT id FROM ".MY_PRF."users WHERE user_login='{$user}'", false);
		$user_id=$user_id['id'];
	}


	if(!isset($_POST['comments']) || empty($_POST['comments'])) {
		bmc_template('error_page', $lang['empty_fields']);
	}

	// Save the comment

	// Save the name,email,url for unregistered users
	if(empty($user)) {
		$db->query("INSERT INTO ".MY_PRF."comments (auth_name,auth_email,auth_url,auth_ip,data,post,date,blog) VALUES('{$_POST['name']}','$email','$url','".$_SERVER['REMOTE_ADDR']."','{$_POST['comments']}','{$_POST['id']}','".time()."','{$_REQUEST['blog']}')");
	} else {
		$db->query("INSERT INTO ".MY_PRF."comments (author,auth_ip,data,post,date,blog) VALUES('{$user_id}','".$_SERVER['REMOTE_ADDR']."','{$_POST['comments']}','{$_POST['id']}','".time()."','{$_REQUEST['blog']}')");
	}

	$result=$db->query("SELECT blog_file FROM ".MY_PRF."blogs WHERE id='{$blog_id}' AND frozen='0'", false);

	// Set the cookie for 'once per session' comment
	if($bmc_vars['m_cmt_ses']) {
		$commented[$_REQUEST['id']]=1;
		setcookie('bmc_cmt_sess',serialize($commented),0,BMC_COOKIE,BMC_COOKIE_DOMAIN);
	}


	bmc_Go($i_blog['blog_file']."?id={$_POST['id']}");

}


?>