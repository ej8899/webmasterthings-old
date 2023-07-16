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


	// Check whether user registration is being accepted at present
	if(!$bmc_vars['m_user']) {
		// Nopes!
		bmc_Template('page_header', $lang['user_no_accept']);
		echo $lang['user_no_accept'];
		bmc_Template('page_footer');
		exit;
	}



	// Show the user registration form
	if(!isset($_POST['action'])) {
		bmc_Template('page_header', $lang['user_reg_title']);
		include CFG_PARENT."/templates/".CFG_THEME."/register.inc.php";
		bmc_Template('page_footer');
		exit;
	}




// Check for empty fields
if(empty($_POST['password']) || empty($_POST['user_login']) || empty($_POST['full_name']) || empty($_POST['email']) || empty($_POST['blogs'])) {
	bmc_template('error_page', $lang['empty_fields'],$lang['empty_fields']);
}

// Userneame too short
if(strlen($_POST['user_login']) < 3) {
	bmc_template('error_page', $lang['user_short_user']);
}

// Userneame too short
if(strlen($_POST['password']) < 5) {
	bmc_template('error_page', $lang['user_short_pass']);
}

	// Check whether the user already exists
	$user=$db->row_count("SELECT id FROM ".MY_PRF."users WHERE user_login='{$_POST['user_login']}' OR user_email='{$_POST['email']}'", false);

	if($user) {
		// Yes! He does!!
		bmc_template('error_page', $lang['user_exists_msg'],$lang['user_exists_msg']);
	}


	// Check whehter the user is trying to register himself on frozen blogs
	for($n=0;$n<count($_POST['blogs']);$n++) {
		if($db->row_count("SELECT id FROM ".MY_PRF."blogs WHERE id='{$_POST['blogs'][$n]}' AND frozen='true'")) {
			bmc_Template('error_page',$lang['user_blogs_no_assoc']);
		}
	}

	$blog_list=serialize($_POST['blogs']);

	$time=time(); // The signup time

	$level=$bmc_vars['m_default_level']; // Default user level

	// Add the user to the DB
	$db->query("INSERT INTO ".MY_PRF."users (user_login,user_name,user_pass,user_email,user_url,date,blogs,level) VALUES('{$_POST['user_login']}','{$_POST['full_name']}','".md5($_POST['password'])."','{$_POST['email']}','{$_POST['url']}','$time','$blog_list','$level')");

	// Send a welcome mail if set
	if($bmc_vars['m_new_welcome']) {

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/plain\r\n";
		$headers .= "From: {$bmc_vars['c_email']}\r\n";
		$headers .= "Reply-To: {$bmc_vars['c_email']}\r\n";
		$headers .= "X-Mailer: Server - {$bmc_var['c_urls']}";


		// Load the message
		$message=@fread(fopen(CFG_PARENT."/templates/welcome_user.txt","r"), filesize(CFG_PARENT."/templates/welcome_user.txt"));

		// Replace the custom tags with real values (See docs for information)
		$message=str_replace("[NAME]", $_POST['full_name'],$message);
		$message=str_replace("[MY_SITE]", $bmc_vars['c_urls'],$message);
		$message=str_replace("[USERNAME]", $_POST['user_login'],$message);
		$message=str_replace("[PASSWORD]", $_POST['password'],$message);
		$message=str_replace("[DATE]", bmcDate($time),$message);

		// Send the mail
		mail(trim($_POST['email']), $lang['user_welcome_subject']." : ".$bmc_vars['c_urls'], $message, $headers);
	}


	// Notify you if necessary
	if($bmc_vars['m_new_notify']) {

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/plain\r\n";
		$headers .= "From: {$bmc_vars['c_email']}\r\n";
		$headers .= "Reply-To: {$bmc_vars['c_email']}\r\n";
		$headers .= "X-Mailer: Server - {$bmc_var['c_urls']}";


		// Load the message
		$message=@fread(fopen(CFG_PARENT."/templates/new_user_notify.txt","r"), filesize(CFG_PARENT."/templates/new_user_notify.txt"));

		// Replace the custom tags with real values (See docs for information)
		$message=str_replace("[NAME]", $_POST['full_name'],$message);
		$message=str_replace("[MY_SITE]", $bmc_vars['c_urls'],$message);
		$message=str_replace("[USERNAME]", $_POST['user_login'],$message);
		$message=str_replace("[PASSWORD]", $_POST['password'],$message);
		$message=str_replace("[DATE]", bmcDate($time),$message);

		// Send the mail
		mail(trim($bmc_vars['c_email']), $lang['user_notify_subject']." : ".$bmc_vars['c_urls'], $message, $headers);

	}

bmc_Template('page_header', $lang['user_reg_success_title']);
echo $lang['user_reg_success_msg'];
bmc_Template('page_footer'); exit;


?>