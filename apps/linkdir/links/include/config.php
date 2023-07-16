<?
// *******************************************************************
//  include/config.php
// *******************************************************************

// *******************************************************************
//  MySQL Connection Information
//  leave $dbhost as is.  localhost will work on most virtual servers
//  change dbuser to your usr login
//  change dbpasswd to your login password
//  change dbname to your database name
//  All the above settings must be completed before installing PHPLinks
// *******************************************************************

// MySQL server hostname
	$dbhost		=	"mysql.4ph.com";

// MySQL server username
	$dbuser		=	"ejohnson";

// MySQL server password
	$dbpasswd	=	"changeme";

// MySQL database name
	$dbname		=	"ejohnson1";

// *******************************************************************
//  phpLinks Language
//  choose your language here.
//
// *******************************************************************

	$language	=	"english";

// *******************************************************************
//  MySQL Table Names
// *******************************************************************

	$tb_categories		=	"wtlinks_categories";
	$tb_links		    =	"wtlinks_links";
	$tb_settings		=	"wtlinks_settings";
	$tb_temp			=	"wtlinks_temp";
	$tb_related		=	"wtlinks_related";
	$tb_terms			=	"wtlinks_terms";
	$tb_reviews		=	"wtlinks_reviews";
	$tb_specs			=	"wtlinks_specs";
	$tb_sessions		=	"wtlinks_sessions";

// *******************************************************************
//	Other Settings
//	
// *******************************************************************

	// These are default values you can set to prefill the blanks
	// when you manually add a site from admin.  Can be blank as well.
	$prefill_email		=	"user@email.com";
	$prefill_username	=	"username";
	$prefill_password	=	"password";
	$prefill_hint		=	"hint";

?>
