<?
// Secret configuration information for phpHoo3
// Keep this file in a dir outside of the web tree
// chmod 600 to protect against other users on your server

include "../wtuserinfo.php";

$ADMIN_USER = "spudley";                   // Username to enter admin mode
$ADMIN_PASS = "scubag";                   // Password to enter admin mode
$ADMIN_COOKIE = "qwetreasdgfd";         // Secret cookie to signal admin mode

$SQL_DBASE = "$wtdatabase";               // Set name of database to use
$SQL_USER = "$wtdb_user";                  // Set database username
$SQL_PASS = "$wtdb_pass";                  // Set database R/W password
$SQL_SERVER = "$wtserver";            // Set server name

?>
