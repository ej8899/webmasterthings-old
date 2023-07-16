<?
// To improve security, chmod 600 this include file - and keep it outside the web-tree:
include "phpHoo3_config.php";

$TEMPLATE_FILE = "template.htm";      // Path to the template file
$SITE_NAME = "links";               // Title of the site (keep short)
$ADMIN_MODE = false;                  // Set true for admin version
$SEE_ALL_SUBMISSIONS = true;          // Set false to show submissions in this category only
$SITE_URL = "http://www.webmasterthings.com/";  // Set real URL of site
$SITE_DIR = "apps/linkdir/phpHoo3.php";      // Appended to SITE_URL for complete address
$FULL_ADMIN_ACCESS = true;            // True to allow admin to create categories
$TOP_CAT_NAME = "Top";                // Name of the top "category"
$ADMIN_EMAIL = "wtlinks@webmasterthings.com"; // Admin email address used for new links
$SMTP_HOSTNAME = "mail.4ph.com";
$SMTP_LOCALHOST = "localhost";
$AUTOAPPROVE = false;                 // True to automatically approve submissions
$REQUIRE_SUBMIT_EMAIL = false;        // True to require email for any submissions
$SQL_CAT_TBL = "wt_ldirMyCategories";        // MySQL table name for the categories table
$SQL_LNK_TBL = "wt_ldirMyLinks";             // MySQL table name for the links table
$wto=$wt_owner;
?>