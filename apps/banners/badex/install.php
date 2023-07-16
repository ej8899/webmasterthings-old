<?


include("config.php");

if (!isset($install)){
?>
<html>
	<head>
	<title>phpBannerExchange Install</title>
</head>
<body>
	At this point, you should have done the following:<br>
	~Uploaded *ALL* the files to your server<br>
	~Defined the variables in config.php<br>
	~Created the database you would like to use for the exchange<p>
	If you have not done any of these steps, please do it now, and do not continue.  Otherwise, click on the "Continue" link below<p>
<?
echo "<br><A href=\"$PHP_SELF?install=1\">Continue</a>";
}

elseif ($install==1){
echo "<p>Creating the <b>banneradmin</b> table in $dbname<br>";

mysql_query("CREATE TABLE wt_banneradmin (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   adminuser varchar(15) NOT NULL,
   adminpass varchar(15) NOT NULL,
   PRIMARY KEY (id),
   UNIQUE id (id, adminuser)
)");
echo "<b>Success</b><p>";

echo "<p>Creating the <b>banneruser</b> table in $dbname<br>";
mysql_query("CREATE TABLE wt_banneruser (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   login varchar(20) NOT NULL,
   pass varchar(20) NOT NULL,
   name varchar(200) NOT NULL,
   email varchar(100) NOT NULL,
   url varchar(200) NOT NULL,
   exposures int(11) DEFAULT '0' NOT NULL,
   credits int(11) DEFAULT '0' NOT NULL,
   clicks int(11) DEFAULT '0' NOT NULL,
   siteclicks int(11) DEFAULT '0' NOT NULL,
   approved tinyint(4) DEFAULT '0' NOT NULL,
   defaultacct tinyint(4) DEFAULT '0' NOT NULL,
   raw varchar(255),
   lastip text NOT NULL,
   PRIMARY KEY (id),
   UNIQUE id (id, login)
)");
echo "<b>Success</b><p>";

echo "<p>Creating the <b>banneruser</b> table in $dbname<br>";
mysql_query("CREATE TABLE wt_bannerurls (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   bannerurl varchar(200) NOT NULL,
   uid int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE id (id)
)");
echo "<b>Success</b><p>";
echo "No errors? Good. That means that all the DB tables have been installed and you're ready to move on to <a href=\"$PHP_SELF?install=2\">the next step</a>!";
}

elseif ($install==2){
	?>
<form method="POST" action="<?echo "$PHP_SELF?install=3"; ?>"><table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="255">
  <tr>
    <td colspan=2 width="282">
    <p align="center"><b>Create Admin Login/Password</b></td>
  </tr>
  <tr>
    <td width="133">Login</td>
    <td width="148"><input type="text" name="login" size="20"></td>
  </tr>
  <tr>
    <td width="133">Password</td>
    <td width="148"><input type="text" name="pass" size="20"></td>
  </tr>
  <tr>
    <td width="133">Password Again</td>
    <td width="148"><input type="text" name="pass2" size="20"></td>
  </tr>
</table>
  <p><input type="submit" value="Submit"><input type="reset" value="Reset"></p>
</form>
<?

}
elseif ($install==3){
		if($pass==$pass2){
	echo "Inserting Admin username and password into banneradmin...<p>";
	mysql_query("insert into wt_banneradmin values ('','$login','$pass')");
	echo "<b>Success</b><p>";
	echo "No errors? Good. That means that your admin login and password has been inserted into the banneradmin table, and you're ready to move on to <a href=\"$PHP_SELF?install=4\">the next step</a>!";
	}else{
	echo "Your Passwords don't match! Press the Back Button and try again!";
	}
}

elseif ($install==4){

echo "phpBannerExchange has been successfully installed! You may now log in to the <a href=\"$base_url/admin/index.php\">Admin Control Panel</a> using the userid and password you have just created!<p><h3>DELETE THIS FILE (install.php) IMMEDIATELY!</h3>";
}

?>