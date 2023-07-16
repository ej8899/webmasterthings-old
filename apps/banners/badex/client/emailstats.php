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
 $result = mysql_query("select * from banneruser where login='$login' AND pass='$pass'");
$get_userinfo=@mysql_fetch_array($result);
$uid=$get_userinfo[id];
$udblogin=$get_userinfo[login];
$udbpass=$get_userinfo[pass];
    if($udblogin=="" AND $udbpass=="" OR $udbpass=="") {
?><html><head><title><? echo"$exchange_name"; ?> - LOGIN ERROR!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>
<br><br>&nbsp;
    <center><b>LOGIN ERROR!</b><br><br>The information you entered was incorrect or not found in the database! Please <a href="../index.php">go back</a> and try again!<br><br>
<? include("../footer.php");
}else {
?>
		<html><head><title><? echo"$exchange_name"; ?> - Email Stats</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<br><br>
<?
	$get_stats=mysql_query("select * from banneruser where id='$uid'");
	$list_stats=mysql_fetch_array($get_stats);
	$email=$list_stats[email];
	$name=$list_stats[name];
	$exposures=$list_stats[exposures];
	$credits=$list_stats[credits];
	$clicks=$list_stats[clicks];
	$siteclicks=$list_stats[siteclicks];

	$subject = "Stats for account ".$login." on ".$exchange_name."";
	$content = "Hello $name,\n\nYour stats are as follows:\n\nExposures: $exposures\nClicks to your site: $siteclicks\nClicks from your site: $clicks\nCredits: $credits\n\n As always, you may check your stats at any time by going to:\n\n$base_url \n\n$owner_name\n\nYou are recieving this email because someone requested that we email their stats for $exchange_name.  If you did not sign up for this service or did not request this information, please accept our apologies.";
	mail($email,$subject,$content,"From: $owner_email");
?>
<center>An email was sent to <? echo"$email"; ?> and will be arriving shortly.<br><br> <form action=stats.php method=post>
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=login value=<? echo "$login"; ?>>
<input type=hidden name=pass value=<? echo "$pass"; ?>>
<input type="submit" value="Back to Stats">
</form>
<? include("../footer.php"); ?>
	<?
	}
	?>