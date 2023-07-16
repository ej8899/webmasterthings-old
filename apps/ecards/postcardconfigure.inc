<?PHP
require "../wtuserinfo.php";

//	$wtserver         = "mysql.4ph.com";           	// Your mySQL Server
//	$wtdb_user        = "ejohnson";           	// Your mySQL Username
//	$wtdb_pass        = "changeme";           	// Your mySQL Password
//	$wtdatabase       = "ejohnson1";             	// Database Name
//	$wttablename		= "wt_users";			// table name
	
$host = "$wtserver";  //MySQL Host
$user = "$wtdb_user"; //MySQL Username
$password = "$wtdb_pass"; //MySQL Password
$db = "$wtdatabase"; //MySQL Database
$table = "wt_postcards"; //MySQL Table

$enablesounds = "1"; //Allow background music as an option. 1=On 0=off
$emoticons = "1";  // Enable-Disable "Smilies" in cards.  1=On 0=off
$emoticonpath="http://www.webmasterthings.com/apps/guestbook/images/smilies"; // web path with out trailing slash to emoticons

$usecron = "1"; // Allow cards to be dated to send at a later time 1=on 0=off(cards only sent immediately)
$notifysender = "1"; // Sends an email message to the sender when the card is picked-up 1=On 0=off
$sitename = "$wtdb[sitename]";  //Site Name, not necessarily domain name

$installpath = "http://www.webmasterthings.com/apps/ecards";  //No trailing slash. That's URL path, NOT the server path.

?>