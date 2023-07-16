<?
//
//  Program: ad_link.php
//  Author: Tony Wells (tony@thinkudyne.com)
//  Description: Redirects client browser to banner target URL
//  Version: 1.00
//  Notes: Clicking on a banner will call this program with the ad_id as
//         a GET argument.  The click-thru is logged and the clients browser
//         is redirected to the target URL.

// SET THE VARIABLES IN THESE NEXT 4 LINES TO YOUR HOST/DB/USER/PASSWORD! 
if (!(isset($dbhost))) {$dbhost = 'your.mysql.host.com';}
if (!(isset($dbname))) {$dbname = 'bannerdb';}
if (!(isset($dbuser))) {$dbuser = 'banneruser';}
if (!(isset($dbauth))) {$dbauth = 'bannerpassword';}

//
// NO NEED TO CHANGE ANYTHING BELOW HERE UNLESS YOU WANT TO HACK THIS SCRIPT!
//

if (!(isset($li))) {
	$li = mysql_connect ($dbhost, $dbuser, $dbauth);
}

// Find out where this banner should redirect the client
$sql = "SELECT link_url FROM banners WHERE ad_id = $ad_id";
$rv = mysql_db_query ($dbname, $sql, $li);
$row = mysql_fetch_array ($rv);
$URL = $row[link_url];

// One more sucker clicked a banner
$sql = "UPDATE banner_stats SET clicks=clicks+1 WHERE ad_id = $ad_id";
$rv = mysql_db_query ($dbname, $sql, $li);

// Send 'em packing
header ("Location: $URL");
?>
