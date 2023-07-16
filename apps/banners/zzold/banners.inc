<?
//
//  Program: banners.inc
//  Author: Tony Wells <tony@thinkudyne.com>
//  Description: Banner generation code
//  Version: 1.1
//  Notes:  This file must be included on any page that you wish to display
//          banners on.  Banners in each zone are displayed sequentially,
//          avoiding the problem of not-so-random random number generators.
//
//          If you experience problems with persistent connections, change
//          the mysql_pconnect call to mysql_connect below.
//
//  Changes:
//  08/28/2001  Add functionality for "TARGET" in the link URL
//  08/01/2001  The function now checks to make sure the banner is "active"
//              before displaying it.

// SET THE VARIABLES IN THESE NEXT 4 LINES TO YOUR HOST/DB/USER/PASSWORD! 
if (!(isset($dbhost))) {$dbhost = 'your.mysql.host.com';}
if (!(isset($dbname))) {$dbname = 'bannerdb';}
if (!(isset($dbuser))) {$dbuser = 'banneruser';}
if (!(isset($dbauth))) {$dbauth = 'bannerpassword';}

// SET THIS VARIABLE TO THE URL OF THE FILE ad_link.php
$ad_link_loc = '/ad_link.php';  // You can leave this if you put the file
                                // in the DOCUMENT_ROOT of your server.

//
// NO NEED TO CHANGE ANYTHING BELOW HERE UNLESS YOU WANT TO HACK THIS SCRIPT!
//

if (!(isset($li))) {
	$li = mysql_pconnect ($dbhost, $dbuser, $dbauth);
}

// This is the function that gets the job done.  The first argument is a MySQL
// link identifier and the second is an integer which is the zone_id for the
// zone you wish to display.  (You can see example code to insert for a zone 
// under "Show zone PHP" in the admin page.)
function show_banner ($li, $zone) {
	global $dbname, $ad_link_loc;

	$sql = "SELECT a.raw_html,a.ad_id,a.banner_url,a.link_url,c.next,a.target 
			FROM banners AS a,zones AS b,master_zones AS c 
			WHERE a.ad_id = b.ad_id
			AND b.zone_id = $zone 
			AND a.active != 'N'
			AND c.zone_id = $zone";
	$rv = mysql_db_query ($dbname, $sql, $li);
	$i = 0;
	while ($row = mysql_fetch_array ($rv)) {
		$ad_ids[$i][0] = $row[ad_id];
		$ad_ids[$i][1] = $row[banner_url];
		$ad_ids[$i][2] = $row[link_url];
		$ad_ids[$i][3] = $row[next];
		$ad_ids[$i][4] = $row[raw_html];
		$ad_ids[$i][5] = $row[target];
		$i++;
	}
	$max = $i;
	if (!($max)) {
		return (1);
	}
	$next = $ad_ids[0][3];
	$index = ($next % $max);  // Modulo arithmetic is my friend

	$selected_ad_id = $ad_ids[$index][0];
	$banner_url = $ad_ids[$index][1];
	$link_url = $ad_ids[$index][2];
	$raw_html = $ad_ids[$index][4];
	$target = $ad_ids[$index][5];

	// Just reguritate some raw HTML
	if ($raw_html) {
		print "$raw_html";
	}
	// This banner has a target URL so make it linked
	elseif ($link_url && !($target)) {
		print "<A HREF=\"$ad_link_loc?ad_id=$selected_ad_id\">";
		print "<IMG SRC=\"$banner_url\" BORDER=\"0\"></A>";
	}
	elseif ($link_url && $target) {
		print "<A HREF=\"$ad_link_loc?ad_id=$selected_ad_id\" TARGET=\"$target\">";
		print "<IMG SRC=\"$banner_url\" BORDER=\"0\"></A>";
	}
	// This banner is just for show (no target URL)
	else {
		print "<IMG SRC=\"$banner_url\" BORDER=\"0\">";
	}

	// Log the exposure
	$sql = "UPDATE banner_stats SET exposures=exposures+1 WHERE ad_id = $selected_ad_id";
	$rv = mysql_db_query ($dbname, $sql, $li);

	// Update the zone index so the next banner gets shown
	$sql = "UPDATE master_zones SET next=next+1 WHERE zone_id = $zone";
	$rv = mysql_db_query ($dbname, $sql, $li);
}
?>
