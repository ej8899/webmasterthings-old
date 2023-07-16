<?
// *******************************************************************
//  admin/setup.php
// *******************************************************************

include("../include/config.php");
include("../include/functions.php");

include("../include/common.php");
$language = $gl["Language"];

include("../include/lang/$language.php");

include("../include/session.php");
// tcm remove php warning
// session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<title></title>
<link rel = "stylesheet" type = "text/css" href = "style.css" />
</head>
<?=$adm_body?>
<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<tr>
	<td class="theader">These are the short install/upgrade instructions.  For a more complete version, go to <a href="http://www.newphplinks.com/" target="_self">http://www.newphplinks.com/</a>.</td>
</tr>
</table><br />
<table cellspacing="0" cellpadding="5" border="1" align="center" width="100%">
<tr>
	<td class="theader">Fresh Install:</td>
</tr>
<tr>
	<td class="text">
	<br />
	<ol>
		<li>Upload files.</li>
		<li>Create a database:<br/>mysql> create database PHPLinks or any other name you may be using for your database;  </li>
		<li>Create tables and insert initial data from <a href="NEWPHPLinks.sql" target="_blank">NewPHPLinks.sql</a>.  You may also use PHPMYAdmin and select SQL and choose run the NewPHPLinks.sql file from your hard drive.  If your webhost only allows one MySQL database, then you can change the table names so they don't conflict with any existing tables.</li>
		<li>Go to http://yourdomain.com/phpLinks/admin/.</li>
		<li>Click <a href="./admin/configuration.php?<?=session_name()?>=<?=session_id()?>">Configuration</a> and setup final variables.</li>
	</ol></td>
</tr>
<tr>
	<td class="theader">Upgrade From 2.x:</td>
</tr>
<tr>
	<td class="text">
	<br />
	<ol>
		<li>Backup your current database.</li>
		<li>Upload NewPHPLinks files to a new temporary directory. Overwriting old phpLinks files is not recommended.</li>
		<li>Perform latest database changes in <a href="upgrade.sql" target="_blank">upgrade.sql</a>.  Please note you should not source the entire file in, just the section for your upgrade version.  Open the file and read it first.</li>
		<li>Go to http://yourdomain.com/phpLinks/admin/.</li>
	</ol>
	Special:
	<ul>
		<li>To go from 2.1.1 to 2.1.2a you must run <a href="upgrade/convert_related_2.1.1-2.1.2.php" target="_self">convert_related_2.1.1-2.1.2.php</a>.</li>
	</ul>
	</td>
</tr>
</table>
</body>
</html>
