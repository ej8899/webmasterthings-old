<?
//
//  Program: banners.php
//  Author: Tony Wells <tony@thinkudyne.com>
//  Description: Banner Administration Page
//  Version: 1.01
//  Notes:  The following program is implemented as a finite state machine,
//          therefore the naming convention of the functions.
//
//          You WILL want to put this in a .htaccess protected directory.
//
//
//          If you experience problems with persistent connections, change
//          the mysql_pconnect call to mysql_connect below.
//
//	Changes:
//  08/28/2001  Added "TARGET" for link URL
//  08/01/2001  Banner stats can be viewed on a per-zone basis, and the
//              banner's activity state is displayed.
//  07/30/2001  The Edit Banner page now has the ability to de/activate a
//              banner without changing what zones it's active in.
//  02/28/2001  Make the "Delete zone" part actually work.
//  01/19/2001  Delete banner page now shows what zones the banners are in.
//

// SET THE VARIABLES IN THESE NEXT 4 LINES TO YOUR HOST/DB/USER/PASSWORD! 
if (!(isset($dbhost))) {$dbhost = 'your.mysql.host.com';}
if (!(isset($dbname))) {$dbname = 'bannerdb';}
if (!(isset($dbuser))) {$dbuser = 'banneruser';}
if (!(isset($dbauth))) {$dbauth = 'bannerpassword';}

//
// NO NEED TO CHANGE ANYTHING BELOW HERE UNLESS YOU WANT TO HACK THIS SCRIPT!
//

if (!(isset($li))) {
	$li = mysql_pconnect ($dbhost, $dbuser, $dbauth);
}

// State functions (These reguritate HTML)

// This is the entry page
function show_vertex_0 () {
	global $PHP_SELF;

	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	print "<TABLE BORDER=\"1\" CELLPADDING=\"3\">\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action1\" VALUE=\"Add a new banner\" CLASS=\"Ahelv10\"></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action2\" VALUE=\"Edit an existing banner\" CLASS=\"Ahelv10\"></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action3\" VALUE=\"Delete a banner\" CLASS=\"Ahelv10\"></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action4\" VALUE=\"Add a new zone\" CLASS=\"Ahelv10\"></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action5\" VALUE=\"Delete an existing zone\" CLASS=\"Ahelv10\"></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action6\" VALUE=\"View banner stats\" CLASS=\"Ahelv10\"></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action7\" VALUE=\"Show zone PHP\" CLASS=\"Ahelv10\"></TD></TR>\n";
	print "</TABLE>\n";
	print "</FORM>\n";
}

// This is to add a new banner
function show_vertex_1 ($li) {
	global $PHP_SELF, $dbname, $zones;

	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	print "<TABLE BORDER=\"1\" CELLPADDING=\"3\">\n";
	print "<TR><TD CLASS=\"Ahelv10\">Enter a description of the banner:</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"descr\" SIZE=\"64\" MAXLENGTH=\"255\"></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Enter the location of the banner:</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"banner_url\" SIZE=\"64\" MAXLENGTH=\"255\" VALUE=\"http://\"></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Enter where the banner should link: (optional)</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"link_url\" SIZE=\"64\" MAXLENGTH=\"255\" VALUE=\"http://\"></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Target: (If you need to target a new frame or window)</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"target\" SIZE=\"64\" MAXLENGTH=\"255\" VALUE=\"\"></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Enter raw HTML (CLICK-THRU STATS WILL NOT BE UPDATED FOR THIS TYPE OF BANNER)</TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\"><TEXTAREA NAME=\"raw_html\" ROWS=\"6\" COLS=\"40\"></TEXTAREA></TD></TR>\n";
	// We need to generate a list of zones
	print "<TR><TD CLASS=\"Ahelv10\">Select the zones the banner should appear in:</TD></TR>\n";
	print "<TR><TD><SELECT MULTIPLE NAME=\"zones[]\">\n";
	$sql = "SELECT zone_id,descr FROM master_zones ORDER BY descr";
	$rv = mysql_db_query ($dbname, $sql, $li);
	while ($row = mysql_fetch_array ($rv)) {
		print "<OPTION VALUE=\"$row[zone_id]\">$row[descr]\n";
	}
	print "</SELECT></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Submit\"></TD></TR>";
	print "</TABLE>\n";
	print "<INPUT TYPE=\"hidden\" NAME=\"vertex\" VALUE=\"1\">\n";
	print "</FORM>";
}

// This is to edit an existing banner
function show_vertex_2 ($li) {
	global $PHP_SELF, $dbname;

	print "<TABLE BORDER=\"1\">\n";
	print "<TR><TD><FONT CLASS=\"Ahelv10\">Select a banner to edit:</TD></TR>\n";
	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	$sql = "SELECT ad_id,descr FROM banners ORDER BY descr";
	$rv = mysql_db_query ($dbname, $sql, $li);
	print "<TR><TD><SELECT NAME=\"ad_id\">\n";
	while ($row = mysql_fetch_array ($rv)) {
		print "<OPTION VALUE=\"$row[ad_id]\">$row[descr]</OPTION>\n";
	}
	print "</SELECT></TD></TR>";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action2a\" VALUE=\"Submit\" CLASS=\"Ahelv10\"> ";
	print "<INPUT TYPE=\"submit\" NAME=\"\" VALUE=\"Cancel\" CLASS=\"Ahelv10\"></TD></TR>\n";
	print "</TABLE>\n";
	print "<INPUT TYPE=\"hidden\" NAME=\"vertex\" VALUE=\"2\">\n";
	print "</FORM>\n"; 
}

function show_vertex_2a ($li) {
	global $PHP_SELF, $dbname, $ad_id;

	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	$sql = "SELECT descr,banner_url,link_url,raw_html,active,target
			FROM banners 
			WHERE ad_id = $ad_id";
	$rv = mysql_db_query ($dbname, $sql, $li);
	$row = mysql_fetch_array ($rv);

	// Reflect status of 'active'
	$tmp = $row[active];
	$selected[$tmp] = "CHECKED";

	print "<TABLE BORDER=\"1\">\n";
	print "<TR><TD CLASS=\"Ahelv10\">Description:</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"descr\" VALUE=\"$row[descr]\" SIZE=\"64\" MAXLENGTH=\"255\"></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Banner URL:</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"banner_url\" VALUE=\"$row[banner_url]\" SIZE=\"64\" MAXLENGTH=\"255\"></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Link URL:</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"link_url\" VALUE=\"$row[link_url]\" SIZE=\"64\" MAXLENGTH=\"255\"></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Target:</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"target\" VALUE=\"$row[target]\" SIZE=\"64\" MAXLENGTH=\"255\"></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Enter raw HTML (CLICK-THRU STATS WILL NOT BE UPDATED FOR THIS TYPE OF BANNER)</TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\"><TEXTAREA NAME=\"raw_html\" ROWS=\"6\" COLS=\"40\">$row[raw_html]</TEXTAREA></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Banner status: Active <INPUT TYPE=\"radio\" NAME=\"active\" VALUE=\"Y\" $selected[Y]> | Inactive <INPUT TYPE=\"radio\" NAME=\"active\" VALUE=\"N\" $selected[N]></TD></TR>\n";
	print "<TR><TD CLASS=\"Ahelv10\">Select the zones the banner should appear in:</TD></TR>\n";
	$sql = "SELECT zone_id FROM zones WHERE ad_id = $ad_id";
	$rv = mysql_db_query ($dbname, $sql, $li);
	while ($row = mysql_fetch_array ($rv)) {
		$tmp = $row[zone_id];
		$selected_zones[$tmp] = 1;
	}
	print "<TR><TD><SELECT MULTIPLE NAME=\"zones[]\">\n";
	$sql = "SELECT zone_id,descr FROM master_zones ORDER BY descr";
	$rv = mysql_db_query ($dbname, $sql, $li);
	while ($row = mysql_fetch_array ($rv)) {
		$tmp = $row[zone_id];
		if ($selected_zones[$tmp]) {
			print "<OPTION VALUE=\"$row[zone_id]\" SELECTED>$row[descr]\n";
		}
		else {
			print "<OPTION VALUE=\"$row[zone_id]\">$row[descr]\n";
		}
	}
	print "</SELECT></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Submit\"> ";
	print "<INPUT TYPE=\"submit\" NAME=\"\" VALUE=\"Cancel\"></TD></TR>";
	print "</TABLE>\n";
	print "<INPUT TYPE=\"hidden\" NAME=\"ad_id\" VALUE=\"$ad_id\">\n";
	print "<INPUT TYPE=\"hidden\" NAME=\"vertex\" VALUE=\"2a\">\n";
	print "</FORM>\n";
}

// This is to delete an existing banner	
function show_vertex_3 ($li) {
	global $PHP_SELF, $dbname;

	// Get all the existing banners
	$sql = "SELECT ad_id,descr FROM banners ORDER BY descr";
	$rv1 = mysql_db_query ($dbname, $sql, $li);
	while ($banners = mysql_fetch_array ($rv1)) {
		$sql = "SELECT a.descr FROM master_zones AS a,zones AS b WHERE b.ad_id = $banners[ad_id] AND a.zone_id = b.zone_id";
		$rv2 = mysql_db_query ($dbname, $sql, $li);
		print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
		print "<TABLE BORDER=\"1\" CELLPADDING=\"3\">\n";
		print "<TR><TD CLASS=\"Ahelv10\">Ad ID</TD><TD CLASS=\"Ahelv10\" COLSPAN=\"2\">Description</TD><TD CLASS=\"Ahelv10\">Zones</TD></TR>\n";
		print "<TR><TD CLASS=\"Ahelv10\">$banners[ad_id]</TD><TD CLASS=\"Ahelv10\" >$banners[descr]</TD>\n";
		print "<TD><INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Delete\" CLASS=\"Ahelv10\"></TD><TD>\n";
		while ($zones = mysql_fetch_array ($rv2)) {
			print "$zones[descr]<BR>\n";
		}
		print "</TD></TR>\n";
		print "<INPUT TYPE=\"hidden\" NAME=\"ad_id\" VALUE=\"$banners[ad_id]\">\n";
		print "<INPUT TYPE=\"hidden\" NAME=\"vertex\" VALUE=\"3\">\n";
		print "</TABLE></FORM><P>\n";
	}
		print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
		print "<INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Cancel\" CLASS=\"Ahelv10\">\n";
		print "</FORM>\n";

}

// This adds a new banner zone
function show_vertex_4 () {
	global $PHP_SELF, $dbname, $zones;

	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	print "<TABLE BORDER=\"1\" CELLPADDING=\"3\">\n";
	print "<TR><TD CLASS=\"Ahelv10\">Enter a description of the zone:</TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"text\" NAME=\"descr\" SIZE=\"64\" MAXLENGTH=\"255\"></TD></TR>\n";
	print "<TR><TD><INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Submit\"></TD></TR>";
	print "</TABLE>\n";
	print "<INPUT TYPE=\"hidden\" NAME=\"vertex\" VALUE=\"4\">\n";
	print "</FORM>";
}

// This is for deleting zones
function show_vertex_5 ($li) {
	global $PHP_SELF, $dbname;

	print "<FONT CLASS=\"Ahelv12\">Select a zone:</FONT><BR>\n";
	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	print "<SELECT NAME=\"zones\">\n";
	$sql = "SELECT descr,zone_id FROM master_zones";
	$rv = mysql_db_query ($dbname, $sql, $li);
	while ($row = mysql_fetch_array ($rv)) {
		print "<OPTION VALUE=\"$row[zone_id]\">$row[descr]</OPTION>\n";
	}
	print "</SELECT>\n";
	print "<INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Delete zone\"> \n";
	print "<INPUT TYPE=\"hidden\" NAME=\"vertex\" VALUE=\"5\">\n";
	print "</FORM>\n";
}

// This shows the stats for the banner
function show_vertex_6 ($li) {
	global $PHP_SELF, $dbname;

	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	print "<TABLE BORDER=\"1\" CELLPADDING=\"3\">\n";
	print "<TR><TD CLASS=\"Ahelv10\">Select the zone to display stats:</TD></TR>\n";
	// Build a drop-down of the different zones	
	print "<TR><TD CLASS=\"Ahelv10\">\n<SELECT NAME=\"zone\">\n<OPTION VALUE=\"0\">All Zones\n";
	$sql = "SELECT zone_id,descr
			FROM master_zones
			ORDER BY descr";
	$rv = mysql_db_query ($dbname, $sql, $li);
	while ($row = mysql_fetch_array ($rv)) {
		print "<OPTION VALUE=\"$row[zone_id]\">$row[descr]\n";
	}
	print "</SELECT>&nbsp;&nbsp;<INPUT TYPE=\"submit\" NAME=\"action6a\" VALUE=\"Submit\">";
	print "<INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Cancel\"></TD></TR>\n";
	print "<INPUT TYPE=\"hidden\" NAME=\"vertex\" VALUE=\"6\">\n";
	print "</TABLE></FORM>\n";
}

function show_vertex_6a ($li) {
	global $PHP_SELF, $dbname, $zone;

	print "<B><FONT CLASS=\"Ahelv12\">Banner stats</FONT></B><BR>\n";
	print "<TABLE BORDER=\"1\" CELLPADDING=\"3\" WIDTH=\"400\">\n";
	print "<TR><TD CLASS=\"Ahelv12\">Description</TD>";
	print "<TD CLASS=\"Ahelv12\">Date started</TD>";
	print "<TD CLASS=\"Ahelv12\">Exposures</TD>";
	print "<TD CLASS=\"Ahelv12\">Click-thrus</TD>";
	print "<TD CLASS=\"Ahelv12\">Percent click-thrus</TD>\n";
	print "<TD CLASS=\"Ahelv12\">Active?</TD></TR>\n";
	if (!($zone)) {
		$sql = "SELECT b.raw_html,b.banner_url,b.descr,DATE_FORMAT(b.pub_date,'%m/%d/%Y') AS df1,a.exposures,a.clicks,b.active
				FROM banner_stats AS a,banners AS b 
				WHERE a.ad_id = b.ad_id 
				ORDER BY b.descr";
	}
	else {
		$sql = "SELECT b.raw_html,b.banner_url,b.descr,DATE_FORMAT(b.pub_date,'%m/%d/%Y') AS df1,a.exposures,a.clicks,b.active
				FROM banner_stats AS a,banners AS b, zones AS c
				WHERE a.ad_id = b.ad_id 
				AND a.ad_id = c.ad_id
				AND c.zone_id = $zone
				ORDER BY b.descr";
	}
	$rv = mysql_db_query ($dbname, $sql, $li);
	while ($row = mysql_fetch_array ($rv)) {
		print "<TR><TD CLASS=\"Ahelv10\">$row[descr]</TD>";
		print "<TD CLASS=\"Ahelv10\">$row[df1]</TD>";
		print "<TD CLASS=\"Ahelv10\">$row[exposures]</TD>";
		print "<TD CLASS=\"Ahelv10\">$row[clicks]</TD>";
		if ($row[exposures]) {
			$percent = ($row[clicks] / $row[exposures]) * 100;
			$percent = sprintf ("%01.3f", $percent);
			print "<TD CLASS=\"Ahelv10\">$percent</TD>\n";
		}
		else {
			print "<TD CLASS=\"Ahelv10\">No exposures</TD>\n";
		}
		print "<TD CLASS=\"Ahelv10\">$row[active]</TD></TR>";
		if (!($row[raw_html])) {
			print "<TR><TD COLSPAN=\"6\"><IMG SRC=\"$row[banner_url]\"></TD></TR>\n";
		}
		else {
			print "<TR><TD COLSPAN=\"6\" CLASS=\"Ahelv12\">Raw HTML banner</TD></TR>\n";
		}
	}
	print "</TABLE>\n";
	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	print "<INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Exit\" CLASS=\"Ahelv10\">\n";
	print "</FORM>\n";
}

// This displays the PHP associated with a zone
function show_vertex_7 ($li) {
	global $PHP_SELF, $dbname;

	print "<FONT CLASS=\"Ahelv12\">Select a zone:</FONT><BR>\n";
	print "<FORM ACTION=\"$PHP_SELF\" METHOD=\"post\">\n";
	print "<SELECT NAME=\"zones\">\n";
	$sql = "SELECT descr,zone_id FROM master_zones";
	$rv = mysql_db_query ($dbname, $sql, $li);
	while ($row = mysql_fetch_array ($rv)) {
		print "<OPTION VALUE=\"$row[zone_id]\">$row[descr]</OPTION>\n";
	}
	print "</SELECT>\n";
	print "<INPUT TYPE=\"submit\" NAME=\"action7\" VALUE=\"Submit\"> \n";
	print "<INPUT TYPE=\"submit\" NAME=\"action0\" VALUE=\"Exit\"> \n";
	print "<INPUT TYPE=\"hidden\" NAME=\"vertex\" VALUE=\"7\">\n";
	print "</FORM>\n";
}

// State transition functions
// (These functions perform operations that modify the database.)
function edge_1_0 ($li) {
	global $dbname, $descr, $banner_url, $link_url, $zones, $raw_html,
		   $target;

	// Add entry to the banner table
	if (!get_magic_quotes_gpc ()) {
		$descr = mysql_escape_string ($descr);
		$banner_url = mysql_escape_string ($banner_url);	
		$target = mysql_escape_string ($target);	
		$link_url = mysql_escape_string ($link_url);
		$raw_html = mysql_escape_string ($raw_html);
	}
	$raw_html = ereg_replace ("\r", "", $raw_html); // Whack CR



	$sql = "INSERT INTO banners (banner_url,link_url,target,descr,raw_html,pub_date) ";
	$sql .= "VALUES ('$banner_url','$link_url','$target','$descr','$raw_html',NOW())";
	$rv = mysql_db_query ($dbname, $sql, $li);

	// Add entries to the zone table
	$ad_id = mysql_insert_id ($li);
	$count = count ($zones);
	if ($count) {
		for ($i = 0; $i < $count; $i++) {
			$sql = "INSERT INTO zones (ad_id,zone_id) VALUES ($ad_id,$zones[$i])";
			$rv = mysql_db_query ($dbname, $sql, $li);
		}
	}

	// Add entry to the banner_stats table
	$sql = "INSERT INTO banner_stats (ad_id) VALUES ($ad_id)";
	$rv = mysql_db_query ($dbname, $sql, $li);

	
}

function edge_2a_0 ($li) {
	global $dbname, $ad_id, $descr, $banner_url, $link_url, $raw_html, $zones,
		   $active, $target;

	// Add entry to the banner table
	if (!get_magic_quotes_gpc ()) {
		$descr = mysql_escape_string ($descr);
		$banner_url = mysql_escape_string($banner_url);	
		$link_url = mysql_escape_string($link_url);
		$target = mysql_escape_string($target);
	}

	$sql = "UPDATE banners SET descr = '$descr', banner_url = '$banner_url',
	        link_url = '$link_url', raw_html = '$raw_html', 
			active = '$active', target = '$target'
            WHERE ad_id = $ad_id";

	$rv = mysql_db_query ($dbname, $sql, $li);

	$sql = "DELETE FROM zones WHERE ad_id = $ad_id";
	$rv = mysql_db_query ($dbname, $sql, $li);

	// Add entries to the zone table
	$count = count ($zones);
	if ($count) {
		for ($i = 0; $i < $count; $i++) {
			$sql = "INSERT INTO zones (ad_id,zone_id) VALUES ($ad_id,$zones[$i])";
			$rv = mysql_db_query ($dbname, $sql, $li);
		}
	}

}

function edge_3_0 ($li) {
	global $dbname, $ad_id;

	// Delete the from banners
	$sql = "DELETE FROM banners WHERE ad_id = $ad_id";
	$rv = mysql_db_query ($dbname, $sql, $li);
	// Delete from zones;
	$sql = "DELETE FROM zones WHERE ad_id = $ad_id";
	$rv = mysql_db_query ($dbname, $sql, $li);
	// Delete from banner_stats;
	$sql = "DELETE FROM banner_stats WHERE ad_id = $ad_id";
	$rv = mysql_db_query ($dbname, $sql, $li);
}

function edge_4_0 ($li) {
	global $dbname, $descr;

	$descr = ereg_replace ("'", "''", $descr);
	$sql = "INSERT INTO master_zones (descr) VALUES ('$descr')";
	$rv = mysql_db_query ($dbname, $sql, $li);
}

function edge_7_7 () {
	global $zones;

	print "<FONT SIZE=\"+1\"><TT>&lt;? show_banner (\$li,$zones) ?&gt;</TT></FONT>\n";
}


function edge_5_0 ($li) {
	global $dbname, $zones;

	$sql = "DELETE FROM master_zones WHERE zone_id = $zones";
	$rv = mysql_db_query ($dbname, $sql, $li);

	$sql = "DELETE FROM zones WHERE zone_id = $zones";
	$rv = mysql_db_query ($dbname, $sql, $li);
}
?>
<HTML>
<HEAD>
<STYLE TYPE="text/css">
.Ahelv8 {color: #000000; font-size: 8pt; font-family: helvetica;}
.Ahelv9 {color: #000000; font-size: 9pt; font-family: helvetica;}
.Ahelv10 {color: #000000; font-size: 10pt; line-height: 1.0; font-family: helvetica; text-decoration: none;}
.AhelvI10 {color: #000000; font-size: 10pt; line-height: 1.0; font-family: helvetica; text-decoration: none; font-style: italic;}
.Ahelv12 {color: #000000; font-size: 12pt; line-height: 1.0; font-family: helvetica; text-decoration: none;}
.Ahelv14 {color: #000000; font-size: 14pt; font-family: helvetica;}
</STYLE>
<TITLE>Banner Boy: The Fantabulous Banner Whirly-Magig</TITLE>
</HEAD>
<BODY BGCOLOR="#ffffff">
<FONT SIZE="+1"><B>Banner Administration</B></FONT><P>
<?
	// This is the finite state machine
	if ($action0 && $vertex == 1) {
		edge_1_0 ($li);
		show_vertex_0 ();
	}
	elseif ($action0 && $vertex == '2a') {
		edge_2a_0 ($li);
		show_vertex_0 ($li);
	}
	elseif ($action0 && $vertex == 3) {
		edge_3_0 ($li);
		show_vertex_0 ($li);
	}
	elseif ($action0 && $vertex == 4) {
		edge_4_0 ($li);
		show_vertex_0 ($li);
	}
	elseif ($action0 && $vertex == 5) {
		edge_5_0 ($li);
		show_vertex_0 ($li);
	}
	elseif ($action7 && $vertex == 7) {
		show_vertex_7 ($li);
		edge_7_7 ();
	}
	elseif ($action0) {
		show_vertex_0 ();
	}
	elseif ($action1) {
		show_vertex_1 ($li);
	}
	elseif ($action2) {
		show_vertex_2 ($li);
	}
	elseif ($action2a) {
		show_vertex_2a ($li);
	}
	elseif ($action3) {
		show_vertex_3 ($li);
	}
	elseif ($action4) {
		show_vertex_4 ();
	}
	elseif ($action5) {
		show_vertex_5 ($li);
	}
	elseif ($action6) {
		show_vertex_6 ($li);
	}
	elseif ($action6a) {
		show_vertex_6a ($li);
	}
	elseif ($action7) {
		show_vertex_7 ($li);
	}
	else {
		show_vertex_0 ();
	}
?>
</BODY>
</HTML>

