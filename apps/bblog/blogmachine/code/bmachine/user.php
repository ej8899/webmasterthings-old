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


	// Validate the user
	$user=bmc_isLogged(); // the user

	if(empty($user)) {
		bmc_Go($bmc_vars['c_urls']."/login.php");
		exit;
	}

	// ====================
	// Logout (We should allow the user to Logout, even if he's an admin or not :)

	if(isset($_GET['action']) && $_GET['action']=="logout") {
		// Delete the cookies
		setcookie("BMC_user", "" ,time()-604800,BMC_COOKIE,BMC_COOKIE_DOMAIN);
		setcookie("BMC_user_password", "" ,time()-604800,BMC_COOKIE,BMC_COOKIE_DOMAIN);

		bmc_Go($bmc_vars['c_urls']."/login.php");
		exit();
	}


	// Get the userdata
	$user_info=$db->query("SELECT id,user_login,last_login,user_pass,level,blogs FROM ".MY_PRF."users WHERE user_login='{$user}'", false);
	// Extra security check
	if(empty($user_info['user_login'])) {
		bmc_Go($bmc_vars['c_urls']."/login.php");
		exit;
	}

	if(isset($_REQUEST['blog']) && !defined('BLOG')) {
		define("BLOG", $_REQUEST['blog']);
	}

	$logged_user_id=$user_info['id'];

	if(isset($_REQUEST['blog']) && !defined('BLOG') && is_numeric($_REQUEST['blog'])) {
		if(!$db->row_count("SELECT id FROM ".MY_PRF."blogs WHERE id='{$_REQUEST['blog']}' AND frozen='0'")) {
			bmc_template('error_page', $lang['post_no_blog']);
		} else {
			define('BLOG', $_REQUEST['blog']);
		}
	}

	// Perform various actions
	if(isset($_REQUEST['action'])) {

		switch($_REQUEST['action']) {

			// New post
			case 'new_post':
				if($user_info['level'] >= 2) {
					bmc_Template('page_header', $lang['user_new_title']);
					include CFG_ROOT."/inc/users/post_form.php";
					bmc_Template('page_footer');
					exit();
				} else {
					bmc_Go("?null");
				}

			// My account
			case 'my_account':
			case 'edit_user':
			include CFG_ROOT."/inc/users/user.inc.php";
			exit;


			// List the posts
			case 'list_posts';
			case 'delete_posts': // Delete
				if($user_info['level'] >= 2) {
				include CFG_ROOT."/inc/users/posts.inc.php";
				exit;
				} else {
					bmc_Go("?null");
				}

			// Save a new post
			case 'save_post':
				if($user_info['level'] >= 2) {
					include CFG_ROOT."/inc/users/post.inc.php";
					exit;
				} else {
					bmc_Go("?null");
				}

			// Modify a post
			case 'mod_post':
				if($user_info['level'] > 2) {
				include CFG_ROOT."/inc/users/edit.inc.php";
				exit;
				} else {
					bmc_Go("?null");
				}

			// Edit page
			case 'edit_post':
				if($user_info['level'] > 2 && isset($_GET['blog']) && is_numeric($_GET['blog'])) {
				bmc_Template('page_header', $lang['post_edit_title']);
				include CFG_ROOT."/inc/users/edit_form.php";
				bmc_Template('page_footer');
				exit;
				} else {
					bmc_Go("?null");
				}

			// Edit comments
			case 'edit_comments':
			case 'mod_comment':
				if($user_info['level'] > 2) {
				include CFG_ROOT."/inc/core/admin/comments.inc.php";
				exit;
				} else {
					bmc_Go("?null");
				}

			// Delete comments
			case 'delete_comment':
				if($user_info['level'] > 2) {
				include CFG_ROOT."/inc/core/admin/comments.inc.php";
				exit;
				} else {
					bmc_Go("?null");
				}

			default:
			bmc_Go("?null");
	
		}
	}

	// The last login info
	list($last_login, $current_login)=explode("|", $user_info['last_login']);
	bmc_Template('page_header', $lang['user_mbr_title']);

	include CFG_PARENT."/templates/".CFG_THEME."/user.account.php";

	bmc_Template('page_footer');

?>