<?
/////////////////////////////////////////////////
//              phpBannerExchange              //
//              A Free Script by:              //
//                                             //
// darkrose - darkrose@internetunderground.com //
//       lazurus - lazurus@rustedgate.com      //
//                                             //
// Updates and future versons can be found at: //
// http://www.internetunderground.com/scripts/ //
//                                             //
// This script is covered under the GNU GPL.   //
//                                             //
// If you modify this script, please make your //
// code available to us! We are not programmers//
// by trade, so there's bound to be bugs and   //
// inefficient code, but we're trying!         //
/////////////////////////////////////////////////

include("../config.php");
 $result = mysql_query("select * from banneradmin where adminuser='$admlogin' AND adminpass='$admpass'");
$get_userinfo=@mysql_fetch_array($result);
$id=$get_userinfo[id];
$admlogin=$get_userinfo[adminuser];
$admpass=$get_userinfo[adminpass];
    if($admlogin=="" AND $admpass=="" OR $admpass=="") {
?><html><head><title><? echo"$exchange_name"; ?> - LOGIN ERROR!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>
<br><br>&nbsp;
    <center><b>LOGIN ERROR!</b><br><br>The information you entered was incorrect or not found in the database! Please <a href="../index.php">go back</a> and try again!<br><br></center>
<? include("../footer.php");
}else {
?><html><head><title><? echo"$exchange_name"; ?> - CONFIRM Add!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body><?
// let's make sure the account doesn't already exist!
$check_login=mysql_query("select * from banneruser where login='$login'");
		$get_login=@mysql_fetch_array($check_login);
		$exists=$get_login[login];
		if($exists == $login){
	echo "<center><b>An account with the login name $login already exists!</b><br><br>Press your back button and try a different login!</center>";
	}else{
if($approved==Approved){
		$approved=1;
		$yesno="Yes";
	}else{
		$approved=0;
		$yesno="No";
	}
if($defaultacct==defaultacct){	
$defaultacct=1;
$defaultyn="Yes";
}else{
	$defaultacct=0;
	$defaultyn="No";
}
$rawformatted=htmlspecialchars($rawform);
	$insert=mysql_query("insert into banneruser values ('','$login','$pass','$name','$email','$url','$exposures','$credits','$clicks','$siteclicks','$approved','$defaultacct','$rawform','')",$db);
					echo "<br><CENTER><TABLE class=\"windowbg\"><TR><TD>The Account has been added.<br><br>";
					echo "<br><br>Name: $name<br>Login: $login<br>Password: $pass<br>Email: $email<br>uid: $uid<br><br>";
					echo "URL: $url<BR>Exposures: $exposures<BR>Credits: $credits<BR>Clicks: $clicks<BR>Site Clicks: $siteclicks<BR>Approved: $yesno<br>Default Account: $defaultyn<br>RAW Mode: $rawformatted<br>Banner:<br><img src=\"$bannerurl\">";
					$get_id=mysql_query("select id from banneruser where login='$login' AND pass='$pass'");
					$get_rows=mysql_fetch_array($get_id);
					$insert_banner=mysql_query("insert into bannerurls values ('','$bannerurl','$get_rows[id]')");
	?>
						<form method="POST" action="stats.php">
						<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
						<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
						<CENTER><input type="submit" value="Apply Changes"></CENTER>
						</FORM>
						</TD></TR>
						</TABLE>
						</CENTER>
		<?
	}
}
	include("../footer.php"); ?>