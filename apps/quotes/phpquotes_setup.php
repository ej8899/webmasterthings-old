<?php
if (!$admin)
     header("location:admin.php");

include ("config.php");

if (!IsSet($mainfile)) { include ('mainfile.php'); }

include ("header.php");

$title = "phpquotes Plug-in";
if ($ready=="no"){
	$content= "<p>Plug In aborted</p>
		<p>Click <a href=\"admin.php\">here</a> to go back to administrator page.<br />
		Click <a href=\"phpquotes_setup.php\">here</a> to try setup again.</p>";
}
else if ($ready=="yes"){
	
	$insert_plugin = "INSERT INTO plugins VALUES ( '7', 'Quotes', 'phpquotes_admin.php', 'phpquotes.gif', 'phpquotes', '1', 'phpquotes.php', '0', '0', 'block_set', 'phpquotes by Seyed Razavi <seyed@smartmonkey.co.uk>')";


	$result = mysql_query($insert_plugin);


	if ($result == 0) {
		$content = "MySQL says: Error number - " . mysql_errno() . "<br />" . mysql_error();
		if (mysql_errno()== 1050)
			$content .= "<br /><p>You have already installed the phpquotes plug-in<br />
				Please delete phpquotes_setup.php from your directory.</p>";
 	}
	$insert_quotes = "CREATE TABLE phpquotes (
                        qid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
                        quote text,
                        author varchar(150) NOT NULL,
                        PRIMARY KEY (qid)
                       )";  
	
	$result1 = mysql_query($insert_quotes);

	if ($result1 == 0){
		$content = "MySQL says: Error number - " . mysql_errno() . "<br />" . mysql_error();

	}
	
	if ($result && $result1){
		$content = "<span class=\"onebiggerred\">Plug-in Install complete</span><br/>
		<p>The phpquotes should now appear on your homepage. Enjoy!</p>
		<p>After verifying everythings okay you may delete phpquotes_setup.php from your directory.</p>

		";
	}
}

else {
	$content = "<p>This setup installs the phpquotes plug-in into phpWebsite.</p>
		<p>
		<p>
		Are you ready to install phpquotes Plug-in?<br />
		<a href=\"./phpquotes_setup.php?ready=yes\">YES</a>&nbsp;&nbsp;&nbsp;<a href=\"./phpquotes_setup.php?ready=no\">NO</a>
	";
}
themesidebox ($title, $content);


?>


<?php
include ("footer.php");
?>
