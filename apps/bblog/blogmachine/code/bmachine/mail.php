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

// MAIL ARTICLE TO A FRIEND SCRIPT

	include_once dirname(__FILE__)."/config.php";
	include_once dirname(__FILE__)."/$bmc_dir/main.php";



	if(empty($_POST['action']) && empty($_REQUEST['id']) || empty($_REQUEST['blog']) || !is_numeric($_REQUEST['blog'])) { bmc_Go("index.php?mail=false"); }

	// Invalid blog id
	if(!$i_blog['blog_name']) {
		bmc_template('error_page',$lang['no_blog']);
	}

	// Check whether sending posts is enabled
	if(!$bmc_vars['m_send']) {
		bmc_Template('error_page',$lang['snd_no']);
	}

	$i_post=$db->query("SELECT id,author,title,date FROM ".MY_PRF."posts where id='{$_REQUEST['id']}' AND status='1' AND blog='{$i_blog['id']}'", false);

	// Invalid post id
	if(!$i_post['title']) {
		bmc_template('error_page',$lang['no_id']);
	}

	$author=bmc_dispUser($i_post['author']);


// Send to friend Form

if(!isset($_POST['action'])) {
	$title_str=str_replace("%title%",$i_post['title'],$lang['snd_title']);
	bmc_Template('page_header',$title_str,"");
	include CFG_PARENT."/templates/".CFG_THEME."/mail.friend.php";
	bmc_Template('page_footer'); exit();
}

////////////////////

// Some Form validation

if((empty($_POST['e1']) && empty($_POST['e2']) && empty($_POST['e3']) && empty($_POST['e4']) && empty($_POST['e5'])) || (empty($_POST['email']) || !strpos($_POST['email'], "@")) || ($_POST['e1'] && !strpos($_POST['e1'], "@")) || ($_POST['e2'] && !strpos($_POST['e2'], "@")) || ($_POST['e3'] && !strpos($_POST['e3'], "@")) || ($_POST['e4'] && !strpos($_POST['e4'], "@")) || ($_POST['e5'] && !strpos($_POST['e5'], "@"))) {
	bmc_template('error_page', $lang['snd_inv_email'],$lang['snd_inv_email_msg']);

}

///////////////////////////////////////////////////

	$subject=str_replace("[NAME]", $_POST['name'], $bmc_vars['subject']);

	// Open the mail.txt template file and replace keywords
	// with appropriate data

	$message=@fread(fopen(CFG_PARENT."/templates/send_post.txt", "r"), filesize(CFG_PARENT."/templates/send_post.txt"));

	$message=str_replace("[NAME]", $_POST['name'], $message);
	$message=str_replace("[SITE]", $bmc_vars['c_urls']."/".BLOG_FILE, $message);
	$message=str_replace("[URL]", $bmc_vars['c_urls']."/".BLOG_FILE."?id=".$_REQUEST['id'], $message);
	$message=str_replace("[EMAIL]", $_POST['email'], $message);
	$message=str_replace("[TITLE]", $i_post['title'], $message);
	$message=str_replace("[AUTHOR]", $author, $message);
	$message=str_replace("[AUTHOR_PAGE]", $bmc_vars['c_urls']."/profile.php?id=".$i_post['author'] , $message);
	$message=str_replace("[COMMENTS]", $_POST['comments'], $message);
	$message=str_replace("[DATE]", bmcDate($i_post['date']), $message);
	$message=stripslashes($message);

	// Set mail headers

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain\r\n";
	$headers .= "From: {$_POST['email']}\r\n";
	$headers .= "Reply-To: {$_POST['email']}\r\n";
	$headers .= "X-Mailer: PHP {$bmc_vars['c_url']}";


// Send to the emails, if entered
if(!empty($_POST['e1'])) { mail(trim($_POST['e1']), $subject, $message, $headers); }
if(!empty($_POST['e2'])) { mail(trim($_POST['e2']), $subject, $message, $headers); }
if(!empty($_POST['e3'])) { mail(trim($_POST['e3']), $subject, $message, $headers); }
if(!empty($_POST['e4'])) { mail(trim($_POST['e4']), $subject, $message, $headers); }
if(!empty($_POST['e5'])) { mail(trim($_POST['e5']), $subject, $message, $headers); }


// Log the mail
$a = fopen(CFG_ROOT."/inc/vars/mail_log.txt", "a") or bmc_template('error_page', $lang['admin_log_write_msg'], $lang['admin_clr_log_msg']);
$write = fputs($a, bmcDate($i_post['date'])."|{$_POST['name']}|{$_POST['email']}|{$i_post['title']}|{$_REQUEST['id']}|{$_SERVER['REMOTE_ADDR']}|");
	if(isset($_POST['e1'])) { fputs($a, $_POST['e1']."|"); }
	if(isset($_POST['e2'])) { fputs($a, $_POST['e2']."|"); }
	if(isset($_POST['e3'])) { fputs($a, $_POST['e3']."|"); }
	if(isset($_POST['e4'])) { fputs($a, $_POST['e4']."|"); }
	if(isset($_POST['e5'])) { fputs($a, $_POST['e5']."|"); }
	fputs($a, "\n");
fclose($a);


	bmc_Template('page_header', str_replace("%article%","",$lang['snd_success']),"");
	$sent=str_replace("%article%","<a href=\"".BLOG_FILE."?id={$_REQUEST['id']}\">{$i_post['title']}</a>",$lang['snd_success']);

echo $sent."<br /><br />";

	if(isset($_POST['e1'])) { echo "<a href=\"mailto:{$_POST['e1']}\">{$_POST['e1']}</a><br />"; }
	if(isset($_POST['e2'])) { echo "<a href=\"mailto:{$_POST['e1']}\">{$_POST['e2']}</a><br />"; }
	if(isset($_POST['e3'])) { echo "<a href=\"mailto:{$_POST['e1']}\">{$_POST['e3']}</a><br />"; }
	if(isset($_POST['e4'])) { echo "<a href=\"mailto:{$_POST['e1']}\">{$_POST['e4']}</a><br />"; }
	if(isset($_POST['e5'])) { echo "<a href=\"mailto:{$_POST['e1']}\">{$_POST['e5']}</a><br />"; }

bmc_Template('page_footer');

?> 