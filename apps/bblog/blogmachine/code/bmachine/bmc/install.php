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

//******** DONOT TOUCH! *************

$install_mode=true;

//******** DONOT TOUCH! *************


$my_prefix="bmc_"; // Tables prefix

	@include dirname(__FILE__)."/main.php";
	@include dirname(__FILE__)."/inc/vars/bmc_conf.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>boastMachine installation</title>
	<style type="text/css">
	<!--
	@import url("../templates/default/bstyle.css");
	#align_center {
	text-align: center;
	width: 400px;
	}
	//-->
	</style>
</head>
<body>

<div><br /></div>

<div id="align_center">
<div class="form_fields">

<?php
if(!$_POST['install']) {
?>

<h1>boastMachine installation</h1>

<?php
	// Check whether bm is already installed
	if(isset($my_db)) {
	mysql_connect($my_host, $my_user, $my_pass);
	$db=mysql_select_db($my_db);
	mysql_close();

		if($db) {
		echo "Note: ( boastMachine appears to be already installed )<br />\n";
		}

	}

?>

<form method="post" action="install.php" name="install">
<div>
<input type="hidden" name="c_url" value="" />
<input type="hidden" name="install" value="true" />
Autoset directory permissions? : <input type="checkbox" name="set_perm" value="true" /><br />
(Most likely to fail)
<br /><br />
MySQL server : <input type="text" name="db_host" /><br />
MySQL user : <input type="text" name="db_user" /><br />
MySQL password : <input type="password" name="db_pass" /><br />
MySQL database : <input type="text" name="db_name" /><br />
Overwrite existing tables? <input type="checkbox" name="ow" /><br /><br />

Create new database? <input type="checkbox" name="new_db" /><br />
(Only if you dont want to use an existing db)
<br /><br />

Desired admin username : <input type="text" name="admin_id" /><br />
Password : <input type="password" name="admin_pass" /><br />
Password #2 : <input type="password" name="admin_pass2" /><br /><br />

<input type="submit" value="Continue"><br /><br />
<div class="small_text">Warning! Overwriting the tables will destroy all existing data!</div>
</form>
</div>
<a href="http://boastology.com">boastMachine <?php echo BMC_VERSION; ?></a>
</div>

<script type="text/javascript">
<!--
document.install.c_url.value=document.location;
//-->
</script>
</div>
<br /><br />
<?
footer(); exit();
}


// Check the form

if(empty($_POST['db_name'])) {
	echo "<h1>Error!</h1>\nPlease enter your MySQL database name";
	footer(); exit;
}


if(empty($_POST['admin_id']) || strlen($_POST['admin_id']) < 3) {
	echo "<h1>Error!</h1>\nAdmin username empty or too short! (atleast 3 chars)";
	footer(); exit;
}

if(empty($_POST['admin_pass']) || strlen($_POST['admin_pass']) < 5) {
	echo "<h1>Error!</h1>\nAdmin password empty or too short! (atleast 5 chars)";
	footer(); exit;
}

if($_POST['admin_pass'] != $_POST['admin_pass2']) {
	echo "<h1>Error!</h1>\nAdmin passwords donot match!";
	footer(); exit;
}


	// Get the paths
	if(!empty($_SERVER['WINDIR'])) {
		$slash="\\";
	}
	else {
		$slash="/";
	}

		$path=explode($slash, dirname(__FILE__));
		$bmc_path=$path[count($path)-1];

		unset($path[count($path)-1]);

		$root=implode($slash, $path);
		$root=addslashes($root);

	if(empty($_POST['root'])) {
		if(!is_dir($root)) {
		?>
		<strong>Unable to determine the directory path!</strong>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		Please enter the absolute path to the boastMachine installation.<br />
		<input type="text" name="root" size="50" /><br />
		No trailing slash at the end!<br /><br />
		<input type="submit" value="Continue.." />
		<?php
			while(list($key,$value) = each($_POST)) {
				echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$value}\">\n";
			}
		?>
		</form>
		<?php
		footer(); exit;
		}
	} else {
		$root=$_POST['root'];
	}



// Get the variables

$my_host=$_POST['db_host'];
$my_user=$_POST['db_user'];
$my_pass=$_POST['db_pass'];
$my_db=$_POST['db_name'];

// Tables
$tbl_posts=$my_prefix."posts";
$tbl_posts_dat=<<<EOF
CREATE TABLE $tbl_posts (
  id INT(10) NOT NULL AUTO_INCREMENT,
  title TINYTEXT NOT NULL default '',
  summary MEDIUMTEXT NOT NULL default '',
  data MEDIUMTEXT NOT NULL default '',
  author INT(10) NOT NULL default '',
  keyws text NOT NULL default '',
  date TINYTEXT NOT NULL default '',
  draft_date TINYTEXT NOT NULL default '',
  password TINYTEXT NOT NULL default '',
  file TINYTEXT NOT NULL default '',
  format enum('text','html') NOT NULL default 'text',
  status enum('0','1', '2') NOT NULL default '1',
  cat INT(10) NOT NULL default '',
  blog INT(10) NOT NULL default '',
  user_ip TINYTEXT NOT NULL default '',
  m_trackback enum('1','0') NOT NULL default '1',
  m_cmt enum('1','0') NOT NULL default '1',
  m_vote enum('1','0') NOT NULL default '1',
  m_autobr enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (id)
);
EOF;


$tbl_comments=$my_prefix."comments";
$tbl_comments_dat=<<<EOF
CREATE TABLE $tbl_comments (
  id INT(10) NOT NULL AUTO_INCREMENT,
  author INT(10) NOT NULL default '',
  auth_name TINYTEXT NOT NULL default '',
  auth_email TINYTEXT NOT NULL default '',
  auth_url TINYTEXT NOT NULL default '',
  auth_ip TINYTEXT NOT NULL default '',
  date TINYTEXT NOT NULL default '',
  data text NOT NULL default '',
  post INT(10) NOT NULL default '',
  blog INT(10) NOT NULL default '',
  PRIMARY KEY  (id)
);
EOF;


$tbl_cats=$my_prefix."cats";
$tbl_cats_dat=<<<EOF
CREATE TABLE $tbl_cats (
  id INT(10) NOT NULL AUTO_INCREMENT,
  cat_name TINYTEXT NOT NULL default '',
  cat_info TINYTEXT NOT NULL default '',
  blog int(10) NOT NULL default '',
  PRIMARY KEY  (id)
);
EOF;

$tbl_tracks=$my_prefix."trackbacks";
$tbl_tracks_dat=<<<EOF
CREATE TABLE $tbl_tracks (
  id INT(10) NOT NULL AUTO_INCREMENT,
  title TINYTEXT NOT NULL default '',
  url TINYTEXT NOT NULL default '',
  excerpt MEDIUMTEXT NOT NULL default '',
  blog_name TINYTEXT NOT NULL default '',
  date TINYTEXT NOT NULL default '',
  post INT(10) NOT NULL default '',
  PRIMARY KEY  (id)
);
EOF;

$tbl_votes=$my_prefix."votes";
$tbl_votes_dat=<<<EOF
CREATE TABLE $tbl_votes (
  post INT(10) NOT NULL AUTO_INCREMENT,
  number  INT(10) NOT NULL default '',
  total  INT(10) NOT NULL default '',
  PRIMARY KEY  (post)
);
EOF;

$tbl_blogs=$my_prefix."blogs";
$tbl_blogs_dat=<<<EOF
CREATE TABLE $tbl_blogs (
  id INT(10) NOT NULL AUTO_INCREMENT,
  blog_name TINYTEXT NOT NULL default '',
  blog_date TINYTEXT NOT NULL default '',
  blog_info TINYTEXT NOT NULL default '',
  blog_file TINYTEXT NOT NULL default '',
  theme TINYTEXT NOT NULL default '',
  theme_name TINYTEXT NOT NULL default '',
  frozen enum('1','0') NOT NULL default '0',
  m_users enum('1','0') NOT NULL default '1',
  m_rss enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (id)
);
EOF;

$tbl_vars=$my_prefix."vars";
$tbl_vars_dat=<<<EOF
CREATE TABLE $tbl_vars (
  v_name VARCHAR(255) NOT NULL default '',
  v_val VARCHAR(255) NOT NULL default '',
  PRIMARY KEY  (v_name)
);
EOF;

$tbl_users=$my_prefix."users";
$tbl_users_dat=<<<EOF
CREATE TABLE $tbl_users (
  id INT(10) NOT NULL AUTO_INCREMENT,
  user_login TINYTEXT NOT NULL default '',
  user_pass TINYTEXT NOT NULL default '',
  user_name TINYTEXT NOT NULL default '',
  user_nick TINYTEXT NOT NULL default '',
  user_email TINYTEXT NOT NULL default '',
  user_url TINYTEXT NOT NULL default '',
  user_location TINYTEXT NOT NULL default '',
  user_birth TINYTEXT NOT NULL default '',
  user_yim TINYTEXT NOT NULL default '',
  user_msn TINYTEXT NOT NULL default '',
  user_icq TINYTEXT NOT NULL default '',
  user_profile MEDIUMTEXT NOT NULL default '',
  last_login TINYTEXT NOT NULL default '',
  user_pic TINYTEXT NOT NULL default '',
  user_showid enum('user_login','user_name', 'user_nick') NOT NULL default 'user_name',
  user_get_email enum('1','0') NOT NULL default '1',
  user_show_email enum('1','0') NOT NULL default '1',
  user_show_pic enum('1','0') NOT NULL default '1',
  public_profile enum('1','0') NOT NULL default '1',
  date TINYTEXT NOT NULL default '',
  level INT(10) NOT NULL default '2',
  blogs MEDIUMTEXT NOT NULL default '',
  PRIMARY KEY  (id)
);
EOF;

echo "Getting site url...  ";

// Get the site path
$c_url=explode("/",$_POST['c_url']);

unset($c_url[count($c_url)-1]); // Get lost of the name 'install.php'
unset($c_url[count($c_url)-1]); // Ditch the 'bmc' directory name
$c_url=implode("/",$c_url);
echo "Done <br /><br />";


	if(isset($_POST['set_perm'])) {
		echo "Trying to set directory/file permisions...  ";

		echo "{$root}  ".@chmod($root, 0777) or (" <strong>Failed..</strong><br />");
		echo "./backup ..  ".@chmod($root."/".$bmc_path."/backup", 0777) or (" <strong>Failed..</strong><br />");
		echo "./files .. ".@chmod($root."/".$bmc_path."/files", 0777) or (" <strong>Failed..</strong><br />");
		echo "./inc/vars .. ".@chmod($root."/".$bmc_path."/inc/vars", 0777) or (" <strong>Failed..</strong><br />");
		echo "./inc/vars/cache .. ".@chmod($root."/".$bmc_path."/inc/vars/cache", 0777) or (" <strong>Failed..</strong><br />");
		echo "./inc/lang .. ".@chmod($root."/".$bmc_path."/inc/lang", 0777) or (" <strong>Failed..</strong><br />");

		echo "Done <br /><br />";
	}


	// If its not a Win system, check for valid directory permissions
	if(empty($_SERVER['WINDIR'])) {

$perm=fileperms($root);
if($perm != '16895') {
	footer("Directory permission not 777 ! - {$root}");
}

$perm=fileperms($root."/backup");
if($perm != '16895') {
	footer("Directory permission not 777 ! - ./backup");
}

$perm=fileperms($root."/files");
if($perm != '16895') {
	footer("Directory permission not 777 ! - ./files");
}

$perm=fileperms($root."/rss");
if($perm != '16895') {
	footer("Directory permission not 777 ! - ./rss");
}

$perm=fileperms($root."/".$bmc_path."/inc/vars");
if($perm != '16895') {
	footer("Directory permission not 777 ! - ".dirname(__FILE__)."/inc/vars");
}

$perm=fileperms($root."/".$bmc_path."/inc/vars/cache");
if($perm != '16895') {
	footer("Directory permission not 777 ! - ".dirname(__FILE__)."/inc/vars/cache");
}

$perm=fileperms($root."/".$bmc_path."/inc/lang");
if($perm != '16895') {
	footer("Directory permission not 777 ! - ".dirname(__FILE__)."/inc/lang");
}

	}

	echo "Connecting to mysql...  ";
	@mysql_connect($my_host, $my_user, $my_pass) or footer(mysql_error());
	echo "Done <br />";


	// Create a new database if needed
	if(isset($_POST['new_db'])) {
		echo "Creating new database...";
		@mysql_query("CREATE DATABASE {$_POST['db_name']}") or footer(mysql_error());
		echo "Done <br />";
	}


	echo "Selecting database...  ";
	@mysql_select_db($_POST['db_name']) or footer(mysql_error()); 
	echo "Done <br /><br />";

	echo "Dropping existing tables...  ";
	// Delete the tables if Overwriting is set
	if (isset($_POST['ow']))
	{
		@mysql_query("DROP TABLE IF EXISTS `$tbl_posts`") or 	footer(mysql_error());
		@mysql_query("DROP TABLE IF EXISTS `$tbl_comments`") or footer(mysql_error());
		@mysql_query("DROP TABLE IF EXISTS `$tbl_cats`") or footer(mysql_error());
		@mysql_query("DROP TABLE IF EXISTS `$tbl_vars`") or footer(mysql_error());
		@mysql_query("DROP TABLE IF EXISTS `$tbl_users`") or footer(mysql_error());
		@mysql_query("DROP TABLE IF EXISTS `$tbl_blogs`") or footer(mysql_error());
		@mysql_query("DROP TABLE IF EXISTS `$tbl_votes`") or footer(mysql_error());
		@mysql_query("DROP TABLE IF EXISTS `$tbl_tracks`") or footer(mysql_error());
	}
	echo "Done <br /><br />";


// Create the tables

echo "Creating 'posts' table...  "; @mysql_query($tbl_posts_dat) or footer(mysql_error()); echo "Done <br />";
echo "Creating 'comments' table...  "; @mysql_query($tbl_comments_dat) or  footer(mysql_error()); echo "Done <br />";
echo "Creating 'vars' table...  "; @mysql_query($tbl_vars_dat) or  footer(mysql_error()); echo "Done <br />";
echo "Creating 'categories' table...  "; @mysql_query($tbl_cats_dat) or  footer(mysql_error()); echo "Done <br />";
echo "Creating 'votes' table...  "; @mysql_query($tbl_votes_dat) or  footer(mysql_error()); echo "Done <br />";
echo "Creating 'users' table...  "; @mysql_query($tbl_users_dat) or  footer(mysql_error()); echo "Done <br />";
echo "Creating 'trackbacks' table...  "; @mysql_query($tbl_tracks_dat) or  footer(mysql_error()); echo "Done <br /><br />";
echo "Creating 'blogs' table...  "; @mysql_query($tbl_blogs_dat) or  footer(mysql_error()); echo "Done <br /><br />";

// Enter the initial data
echo "Inserting data into 'posts'...  "; @mysql_query("INSERT INTO $tbl_posts (title,cat,author,date,summary,format,blog,user_ip) VALUES('My first post!','1','1','".time()."','This is my first post in the world\'s greatest blogging system! :D','text','1','{$_SERVER['REMOTE_ADDR']}')") or footer(mysql_error()); echo "Done <br />";
echo "Inserting data into 'users'...  "; @mysql_query("INSERT INTO $tbl_users (level,user_login,user_pass,user_name,date,blogs) VALUES('4','{$_POST['admin_id']}','".md5($_POST['admin_pass'])."','Administrator','".time()."','a:1:{i:0;s:1:\"1\";}')") or footer(mysql_error()); echo "Done <br />";



$gmtime=gmmktime(0,0,0,date("m"),date("h"),date("Y")); // GMT time
$mytime=mktime(0,0,0,date("m"),date("h"),date("Y")); // Server's local time
$time_difference=($gmtime-$mytime)/3600; // The time difference between GMT and the server time

echo "Inserting data into 'vars'...  ";
@mysql_query("INSERT INTO $tbl_vars (v_name, v_val) 
VALUES ('words', ''),
('ips', ''),
('theme_name', 'Default'),
('theme', 'default'),
('lang','en.php'),
('c_email','admin@yoursite.com'),
('c_url','$c_url'),
('c_urls','$c_url'),
('s_title','boastMachine BLOG'),
('s_desc','Blog powered by boastMachine'),
('gmt_diff','{$time_difference}'),
('date_str','F j, Y, g:i a'),
('send_ping','0'),
('ping_urls','http://boastology.com/ping\nhttp://rpc.weblogs.com/RPC2'),
('p_page','25'),
('p_total','100'),
('archive','1'),
('x_wrap','30'),
('c_wrap','65'),
('m_cmt','1'),
('m_cmt_guests','1'),
('m_cmt_ses','0'),
('m_vote','1'),
('m_send','1'),
('m_search','1'),
('m_rss','1'),
('m_cnv','1'),
('m_user','1'),
('m_new_welcome','1'),
('m_new_notify','0'),
('m_default_level','2'),
('m_html','0'),
('m_files','1'),
('subject','[NAME] has asked you read this article!'),
('auto_purge','0')
") or footer(mysql_error()); echo "Done <br />";

echo "Inserting data into 'categories'...  "; @mysql_query("INSERT INTO $tbl_cats (cat_name,cat_info,blog) VALUES('General','This is where I post off the topic posts','1')") or footer(mysql_error()); echo "Done <br />";
echo "Inserting data into 'blogs'...  "; @mysql_query("INSERT INTO $tbl_blogs (blog_name,blog_date,blog_info,blog_file) VALUES('My first blog','".time()."', 'This is my weblog #1 and its powered by boastMachine!', 'index.php')") or footer(mysql_error()); echo "Done <br /><br />";

mysql_close();


// The config file
$conf_dat=<<<EOF
<?php

\$done=true;

\$root="$root";

\$bmc_path="$bmc_path";

\$my_host="{$_POST['db_host']}";
	// Your MYSQL server

\$my_user="{$_POST['db_user']}";
	// Your MySQL username

\$my_pass="{$_POST['db_pass']}";
	// Your MySQL password

\$my_db="{$_POST['db_name']}";
	// Your MySQL database name

\$my_prefix="$my_prefix";
	// MySQL tables prefix
?>
EOF;

 echo "Writing data to config file...  ";
// Write the conf file to save the installation info

$w=@fopen(dirname(__FILE__)."/inc/vars/bmc_conf.php","w+") or  footer(mysql_error());
@fputs($w,$conf_dat) or  footer("Cant write to bmc_conf.php! Check permissions");
@fclose($w);
echo "Done <br />";
?>

<h1>Congratulations!</h1>
Congratulations! boastMachine was installed successfully on your webserver!
You can now login to your admin panel at <a href="<?php echo $c_url; ?>/bmc/admin.php"><?php echo $c_url; ?>/bmc/admin.php</a> and login with<br />
Username : <strong><?php echo $_POST['admin_id']; ?></strong> and Password : <strong><?php echo $_POST['admin_pass']; ?></strong><br /><br />
If you have any doubts or queries, you can visit the boastMachine website<br />
Good Luck!

<?php
footer();


function footer($fail=null) {

if($fail) echo "<strong>Failed!</strong> <br /><br /><strong>Error message :</strong> $fail";

?>


</div></div>

</body></html>
<?php
exit;
}
?>