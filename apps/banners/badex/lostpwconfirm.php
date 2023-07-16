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

include("config.php");
 $result = mysql_query("select * from wt_banneruser where login='$login'");
$get_userinfo=@mysql_fetch_array($result);
$login=$get_userinfo[login];
$pass=$get_userinfo[pass];
$email=$get_userinfo[email];
?>
		<html><head><title><? echo"$exchange_name"; ?> - Lost Password</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<br><br>
<?
if ($email==''){
	echo "<center>We cannot send your password because your email account is not on file!<br><br>This could be because you entered the wrong information.</center><br><br>";
}else {
	echo "<center>We have emailed your password to $email - You should be receiving it shortly...</center><br><br>";
	$usrsubject = "".$exchange_name." - Lost Password";
	$usrcontent = "You are recieving this because someone used your email account to sign up for ".$exchange_name.".  If you did not sign up for this service or did not request this information, please accept our apologies.\n\nYour login ID is: $login\nYour Password is: $pass\n\nYou may log on to check your stats, get your HTML code, add and remove banners, and other administrative functions at any time by going to:\n   $base_url\n\nThank you for your interest!\n\n$owner_name.";
	mail($email,$usrsubject,$usrcontent,"From: $owner_email");
}
?>
<center><a href="index.php">Click here</a> To return to the login screen</center><br><br>

<? include("footer.php"); ?>