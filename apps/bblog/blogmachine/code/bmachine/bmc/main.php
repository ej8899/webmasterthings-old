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


//=========================== DO NOT EDIT ANYTHING! ====================
// DONOT TOUCH!


define('IN_BMC', true); // Flag which tells that you are in the boastMachine system
define('BMC_VERSION', "v3.0 platinum");

// ===========================

	@include_once dirname(__FILE__)."/inc/vars/bmc_conf.php";
	if((!isset($done) || !isset($root) || !isset($bmc_path)) && !isset($install_mode)) {
		@include dirname(__FILE__)."/../config.php";
		die("boastMachine is not properly installed! Please point your browser to <a href=\"".$bmc_dir."/install.php\">install.php</a> and complete the installation!");
	}
	if(isset($install_mode) && $install_mode==true) { return; }

	// Load the outer config file
	include_once dirname(__FILE__)."/../config.php";

	// Define the necessary global constants
	define("CFG_PARENT", $root);
	define("CFG_ROOT", $root."/".$bmc_dir);
	define("BMC_DIR", $bmc_dir);

	define("MY_PRF", $my_prefix); // Define the table prefix as a constant

	// Load the DB processor
	include_once CFG_ROOT."/inc/core/db_mysql.php";

	// Load the common functions file
	include_once CFG_ROOT."/functions.php";

	$temp_vars=bmc_getSets(); // Get the settings

		foreach($temp_vars as $dat) {
			$bmc_vars[$dat['v_name']]=$dat['v_val'];
		}

	// $bmc_vars holds all the global settings

	// ================== User pic max dimensions ====

	$bmc_vars['user_pic_width']=200; // Maximum allowed wifht
	$bmc_vars['user_pic_height']=200; // Maximum allowed height
	$bmc_vars['user_pic_size']=25; // Maximum allowed size in KB s

	// ==================


	// The cookie path
	define("BMC_COOKIE", preg_replace("|http://[^/]+|is","", $bmc_vars['c_urls']."/" ));

	// The cookie domain
	$ck_domain=parse_url($bmc_vars['c_urls']);

		if(!strpos("-".$ck_domain['host'], ".")) {
			$cookie_host=""; //$ck_domain['host'];
		} else {
			$cookie_host=".".$ck_domain['host'];
		}

	define("BMC_COOKIE_DOMAIN", $cookie_host);



	// The Language pack
	$lang_file=$bmc_vars['lang'];
		if(!$lang_file) {
			include CFG_ROOT."/inc/lang/en.php";
		} else {
			include CFG_ROOT."/inc/lang/".$lang_file;
		}


if(defined('BLOG')) {
	$blog_id=BLOG;
	$i_blog=$db->query("SELECT * FROM ".MY_PRF."blogs WHERE id='{$blog_id}' AND frozen='0'", false);

	if(!isset($i_blog['blog_file']) || !isset($i_blog['blog_name'])) {
		bmc_template('error_page', $lang['no_blog']);
	}

	define("BLOG_FILE", $i_blog['blog_file']);
	define("BLOG_NAME", $i_blog['blog_name']);

} else {
	if(isset($_REQUEST['blog']) && is_numeric($_REQUEST['blog'])) {

	$i_blog=$db->query("SELECT * FROM ".MY_PRF."blogs WHERE id='{$_REQUEST['blog']}' AND frozen='0'", false);
	define("BLOG_FILE", $i_blog['blog_file']);
	define("BLOG_NAME", $i_blog['blog_name']);

	}
}

//######### Include necessary config files ###############

// Enable the magic Quotes
if (!get_magic_quotes_gpc()) {
	$_GET    = add_magic_quotes($_GET);
	$_POST   = add_magic_quotes($_POST);
	$_COOKIE = add_magic_quotes($_COOKIE);
}

if(isset($install_mode) && $install_mode==true) {
	include CFG_ROOT."/inc/lang/en.php";
}

else {

	// The theme
	if(isset($blog_id)) {

		$blog_theme=$i_blog['theme'];

		// Check whether the blog has a separate theme
			if(!empty($blog_theme)) {
				$theme=$blog_theme;
			} else {
				$theme=$bmc_vars['theme'];	// Use the default theme
			}

	} else {
		$theme=$bmc_vars['theme'];
	}

		if(empty($theme)) { $theme="default"; }
		define("CFG_THEME",$theme); // Global theme name

}

	bmc_chkIP(); // Check whether the user belogs to a banned IP or group

global $lang;

?>