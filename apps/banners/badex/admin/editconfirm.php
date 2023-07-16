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

?><html><head><title><? echo"$exchange_name"; ?> - CONFIRM Edit!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body><?
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
$raw_query=mysql_query("select raw from banneruser where id='$uid'");
$get_raw=mysql_fetch_array($raw_query);
$raw=$get_raw[raw];
if($rawform == ''){
	$rawformatted=htmlspecialchars($raw);
	$update=mysql_query("update banneruser set login='$login',pass='$pass',name='$name',email='$email',url='$url',exposures='$exposures',credits='$credits',clicks='$clicks',siteclicks=$siteclicks,approved='$approved',defaultacct='$defaultacct',raw='$raw' where id='$uid'");
					echo "<br><CENTER><TABLE class=\"windowbg\"><TR><TD>The Account has been edited.<br><br>";
					echo "<br><br>Name: $name<br>Login: $login<br>Password: $pass<br>Email: $email<br>uid: $uid<br><br>";
					echo "URL: $url<BR>Exposures: $exposures<BR>Credits: $credits<BR>Clicks: $clicks<BR>Site Clicks: $siteclicks<BR>Approved: $yesno<br>Default Account: $defaultyn<br>RAW Mode: $rawformatted";
	}else{
	$rawformatted=htmlspecialchars($rawform);
	$update=mysql_query("update banneruser set login='$login',pass='$pass',name='$name',email='$email',url='$url',exposures='$exposures',credits='$credits',clicks='$clicks',siteclicks=$siteclicks,approved='$approved',defaultacct='$defaultacct',raw='$rawform' where id='$uid'");
					echo "<br><CENTER><TABLE class=\"windowbg\"><TR><TD>The Account has been edited.<br><br>";
					echo "<br><br>Name: $name<br>Login: $login<br>Password: $pass<br>Email: $email<br>uid: $uid<br><br>";
					echo "URL: $url<BR>Exposures: $exposures<BR>Credits: $credits<BR>Clicks: $clicks<BR>Site Clicks: $siteclicks<BR>Approved: $yesno<br>Default Account: $defaultyn<br>RAW Mode: $rawformatted";
	}
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

?>
<? include("../footer.php"); ?>